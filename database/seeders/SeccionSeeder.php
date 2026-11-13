<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Profesor;
use App\Models\PeriodoAcademico;
use App\Models\Seccion;

class SeccionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear un Periodo Académico base
        $periodo = PeriodoAcademico::firstOrCreate(
            ['nombre' => 'Ciclo 01-2026'],
            ['fecha_inicio' => '2026-01-15', 'fecha_fin' => '2026-06-30', 'activo' => true]
        );

        // 2. Crear un Profesor base
        $profesor = Profesor::firstOrCreate(
            ['email' => 'cesar@gmail.com'],
            [
                'nombres' => 'Cesar',
                'apellidos' => 'Aguilar',
                'telefono' => '7000-0000'
            ]
        );

        // 3. Crear materias y secciones asociadas a cada carrera
        $carreras = Carrera::all();

        foreach ($carreras as $carrera) {
            // Materia demostrativa por carrera
            $materia = Materia::firstOrCreate(
                ['codigo' => $carrera->codigo . '-101'],
                [
                    'nombre'     => 'Introducción a ' . $carrera->nombre,
                    'carrera_id' => $carrera->id,
                    'uv'         => 4
                ]
            );

            // Crear Sección 01
            Seccion::updateOrCreate(
                [
                    'materia_id'           => $materia->id,
                    'periodo_academico_id' => $periodo->id,
                    'aula'                 => 'Aula A-12',
                ],
                [
                    'carrera_id'      => $carrera->id,
                    'profesor_id'     => $profesor->id,
                    'cupo_maximo'     => 30,
                    'cupo_disponible' => 25,
                    'horario'         => json_encode(['dias' => 'Lu-Mi-Vi', 'hora' => '08:00 - 10:00']),
                ]
            );
        }
    }
}
