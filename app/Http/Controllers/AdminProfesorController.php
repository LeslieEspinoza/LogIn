<?php

namespace App\Http\Controllers;

use App\Models\Profesor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminProfesorController extends Controller
{
    public function index()
    {
        $profesores = Profesor::with('user')->get();
        return view('admin.profesores.index', compact('profesores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres'   => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email'     => 'required|email|max:100|unique:profesores,email|unique:users,email',
            'telefono'  => 'nullable|string|max:20',
            'crear_usuario' => 'nullable|boolean',
        ]);

        $tempPassword = null;

        DB::transaction(function () use ($request, &$tempPassword) {
            $userId = null;

            // Si se marcó la opción de crear cuenta de acceso
            if ($request->boolean('crear_usuario')) {
                $tempPassword = Str::random(8); // Contraseña temporal de 8 caracteres

                $user = User::create([
                    'name'      => $request->nombres . ' ' . $request->apellidos,
                    'email'     => $request->email,
                    'password'  => Hash::make($tempPassword),
                    'rol_id'    => 2, // Rol Docente
                    'is_active' => true,
                ]);

                $userId = $user->id;
            }

            Profesor::create([
                'user_id'   => $userId,
                'nombres'   => $request->nombres,
                'apellidos' => $request->apellidos,
                'email'     => $request->email,
                'telefono'  => $request->telefono,
            ]);
        });

        $redirect = redirect()->route('admin.profesores.index')
            ->with('success', 'Profesor registrado correctamente.');

        if ($tempPassword) {
            $redirect->with('credenciales', [
                'nombre'   => $request->nombres . ' ' . $request->apellidos,
                'email'    => $request->email,
                'password' => $tempPassword,
            ]);
        }

        return $redirect;
    }

    public function update(Request $request, Profesor $profesor)
    {
        $request->validate([
            'nombres'   => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email'     => 'required|email|max:100|unique:profesores,email,' . $profesor->id,
            'telefono'  => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($request, $profesor) {
            $profesor->update([
                'nombres'   => $request->nombres,
                'apellidos' => $request->apellidos,
                'email'     => $request->email,
                'telefono'  => $request->telefono,
            ]);

            // Si tiene usuario vinculado, sincronizamos nombre y correo
            if ($profesor->user) {
                $profesor->user->update([
                    'name'  => $request->nombres . ' ' . $request->apellidos,
                    'email' => $request->email,
                ]);
            }
        });

        return redirect()->route('admin.profesores.index')->with('success', 'Datos del profesor actualizados.');
    }

    public function crearCuenta(Profesor $profesor)
    {
        if ($profesor->user) {
            return back()->with('error', 'Este profesor ya tiene una cuenta vinculada.');
        }

        $tempPassword = Str::random(8);

        DB::transaction(function () use ($profesor, $tempPassword) {
            $user = User::create([
                'name'      => $profesor->nombres . ' ' . $profesor->apellidos,
                'email'     => $profesor->email,
                'password'  => Hash::make($tempPassword),
                'rol_id'    => 2,
                'is_active' => true,
            ]);

            $profesor->update(['user_id' => $user->id]);
        });

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Cuenta de acceso generada.')
            ->with('credenciales', [
                'nombre'   => $profesor->nombres . ' ' . $profesor->apellidos,
                'email'    => $profesor->email,
                'password' => $tempPassword,
            ]);
    }

    public function resetPassword(Profesor $profesor)
    {
        if (!$profesor->user) {
            return back()->with('error', 'El profesor no tiene una cuenta de usuario activa.');
        }

        $nuevaPassword = Str::random(8);

        $profesor->user->update([
            'password' => Hash::make($nuevaPassword)
        ]);

        return redirect()->route('admin.profesores.index')
            ->with('success', 'Contraseña restablecida correctamente.')
            ->with('credenciales', [
                'nombre'   => $profesor->nombres . ' ' . $profesor->apellidos,
                'email'    => $profesor->email,
                'password' => $nuevaPassword,
            ]);
    }

    public function toggleEstado(Profesor $profesor)
    {
        if (!$profesor->user) {
            return back()->with('error', 'Este profesor no tiene cuenta para activar/desactivar.');
        }

        $nuevoEstado = !$profesor->user->is_active;
        $profesor->user->update(['is_active' => $nuevoEstado]);

        $estadoTexto = $nuevoEstado ? 'activada' : 'suspendida';
        return redirect()->route('admin.profesores.index')
            ->with('success', "La cuenta del docente ha sido {$estadoTexto}.");
    }
}
