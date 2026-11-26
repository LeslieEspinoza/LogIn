<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use App\Models\Carrera;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        $carreras = Carrera::all();
        $query = Materia::with('carrera');

        // Filtrar por carrera si el administrador seleccionó una
        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->carrera_id);
        }

        // Paginación para no saturar la vista con las materias de las 13 carreras
        $materias = $query->paginate(15)->appends($request->query());

        return view('admin.materias.index', compact('materias', 'carreras'));
    }

    public function edit(Materia $materia)
    {
        $carreras = Carrera::all();
        return view('admin.materias.edit', compact('materia', 'carreras'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'codigo' => 'required|string|max:10',
            'nombre' => 'required|string|max:255',
            'uv' => 'required|integer',
            'carrera_id' => 'required|exists:carreras,id'
        ]);

        $materia->update($request->all());

        return redirect()->route('admin.materias.index')->with('success', 'Materia actualizada.');
    }

    public function destroy(Materia $materia)
    {
        // Al eliminar, la base de datos manejará la tabla pivote si tienes ON DELETE CASCADE
        // de lo contrario, puedes hacer $materia->prerequisitos()->detach(); previamente.
        $materia->delete();

        return back()->with('success', 'Materia eliminada correctamente.');
    }
}
