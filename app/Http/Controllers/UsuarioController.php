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
    public function eliminarUsuario(User $user)
    {

        if ($user->delete()) {
            return redirect()->route('usuarios')->with('success', 'Usuario eliminado correctamente');
        }

        return redirect()->route('usuarios')->with('error', 'No se pudo eliminar el usuario');
    }

}
