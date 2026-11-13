<?php

namespace App\Http\Controllers;

use App\Models\Carrera;

class HomeController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        // Si es estudiante (rol 3), lo mandamos a sus inscripciones (o su perfil)
        if ($user->rol_id === 3) {
            return redirect()->route('estudiante.dashboard');
        }

        // Si es Admin (1) o Docente (2), lo mandamos al panel estadístico
        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $datos =[
            'totalCarreras' => Carrera::contarTodos(),
        ];
        return view('home.dashboard', $datos);
    }
}
