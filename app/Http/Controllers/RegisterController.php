<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRoleSelection()
    {
        return view('login.seleccion_rol');
    }

    public function showRegistrationForm($tipo)
    {
        if (!in_array($tipo, ['docente', 'estudiante'])) {
            return redirect()->route('register.select');
        }

        $rol_id = ($tipo === 'docente') ? 2 : 3;

        return view('login.registro', compact('tipo', 'rol_id'));
    }

    public function register(Request $request)
    {
        // 1. SANITIZACIÓN: Limpiar espacios e igualar correo a minúsculas
        $request->merge([
            'email' => strtolower(trim($request->email)),
            'name'  => trim(preg_replace('/\s+/', ' ', $request->name)), // Elimina espacios dobles
        ]);

        // 2. VALIDACIÓN ESTRICTA
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u' // Solo permite letras, tildes, ñ y espacios (sin números ni símbolos)
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns', // Valida formato estricto y existencia del dominio DNS
                'max:255',
                'unique:users,email', // Duplicados en tabla 'users'
                'unique:estudiantes,correo_institucional', // Duplicados en tabla 'estudiantes'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers() // Requiere mínimo 8 caracteres, letras y números
            ],
            'rol_id' => ['required', 'in:2,3'],
        ], [
            'name.required'     => 'El nombre completo es obligatorio.',
            'name.regex'        => 'El nombre solo debe contener letras y espacios.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'Por favor, ingresa un correo electrónico válido.',
            'email.unique'      => 'Este correo electrónico ya se encuentra registrado en el sistema.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed'=> 'Las contraseñas no coinciden.',
            'rol_id.in'         => 'El rol seleccionado no es válido.',
        ]);

        // 3. TRANSACCIÓN ATÓMICA: Si algo falla dentro, nada se guarda en la base de datos
        return DB::transaction(function () use ($request) {

            // Crear el usuario
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'rol_id'   => $request->rol_id,
            ]);

            // Iniciar sesión
            Auth::login($user);

            // Si es Estudiante (rol_id = 3)
            if ((int)$user->rol_id === 3) {
                Estudiante::create([
                    'user_id'              => $user->id,
                    'nombres'              => $user->name,
                    'correo_institucional' => $user->email,
                    'paso_actual'          => 1,
                    'completado'           => false,
                ]);

                return redirect()->route('onboarding.perfil')
                    ->with('status', '¡Registro exitoso! Selecciona tu nivel académico para comenzar.');
            }

            // Si es Docente (rol_id = 2)
            return redirect()->route('dashboard')->with('status', '¡Registro exitoso! Bienvenido al sistema.');
        });
    }
}
