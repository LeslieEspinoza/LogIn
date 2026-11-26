<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Http\Requests\InsertarUsuarioRequest;
use App\Http\Requests\ActualizarUsuarioRequest;

class UsuarioController extends Controller
{
    public function index()
    {
        $datos = [
            "usuarios" => User::mostrarTodos(),
            "roles"    => Rol::all()
        ];
        return view('usuario.usuarios', $datos);
    }

    public function insertarUsuario(InsertarUsuarioRequest $request)
    {
        $datos = $request->validated();
        User::create($datos);

        return redirect()->route('usuarios')->with('success', 'Usuario ingresado correctamente');
    }

    public function buscarUsuario(int $id){
        return response()->json(User:: buscarPorId($id));
    }


    public function actualizarUsuario(ActualizarUsuarioRequest $request, $id)
    {
        User::actualizar($id, $request->validated());

        return redirect()->route('usuarios')->with('success', 'Usuario actualizado correctamente.');
    }
    public function alternarEstado(User $user)
    {
        // Si está activo, lo inactiva. Si está inactivo, lo activa.
        $user->update(['is_active' => !$user->is_active]);

        $mensaje = $user->is_active ? 'Usuario reactivado exitosamente.' : 'Usuario dado de baja.';
        return redirect()->route('usuarios')->with('success', $mensaje);
    }

}
