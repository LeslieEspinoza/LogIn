<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Inscripcion;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs Principales
        $totalCarreras = Carrera::count();
        $totalInscripciones = Inscripcion::count();
        $totalDocentes = User::where('rol_id', 2)->count();
        $totalEstudiantes = User::where('rol_id', 3)->count();

        // 1. Datos para Gráfico de Líneas (Inscripciones por Mes en el año actual)
        $mesesNombres = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $inscripcionesQuery = Inscripcion::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $datosInscripciones = [];
        for ($i = 1; $i <= 12; $i++) {
            $datosInscripciones[] = $inscripcionesQuery[$i] ?? 0;
        }

        // 2. Datos para Gráfico de Pastel (Distribución de Estudiantes por Carrera)
        $carrerasData = Carrera::withCount('estudiantes')->get();
        $labelsCarreras = $carrerasData->pluck('nombre')->toArray();
        $totalesPorCarrera = $carrerasData->pluck('estudiantes_count')->toArray();

        return view('home.dashboard', compact(
            'totalCarreras',
            'totalEstudiantes',
            'totalDocentes',
            'totalInscripciones',
            'mesesNombres',
            'datosInscripciones',
            'labelsCarreras',
            'totalesPorCarrera'
        ));
    }
}
