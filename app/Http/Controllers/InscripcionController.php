<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InscripcionController extends Controller
{
    public function misInscripciones()
    {
        // Obtenemos el estudiante asociado al usuario logueado
        $estudiante = auth()->user()->estudiante;

        // Obtenemos las secciones (materias) en las que está inscrito
        $inscripciones = $estudiante ? $estudiante->secciones()->with('materia')->get() : collect();

        // Retornamos la vista con los datos
        return view('estudiantes.inscripciones', compact('inscripciones'));
    }
}
