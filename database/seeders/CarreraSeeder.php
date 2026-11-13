<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carrera;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            // --- Facultad de Ciencias Económicas (Pregrado) ---
            [
                'nombre'   => 'Licenciatura en Administración de Empresas',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'LAE'
            ],
            [
                'nombre'   => 'Licenciatura en Contaduría Pública',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'LCP'
            ],
            [
                'nombre'   => 'Licenciatura en Mercadotecnia',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'LMK'
            ],
            [
                'nombre'   => 'Licenciatura en Informática',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'INF'
            ],
            [
                'nombre'   => 'Licenciatura en Administración Turística',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'LAT'
            ],
            [
                'nombre'   => 'Técnico en Software',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'TSW'
            ],
            [
                'nombre'   => 'Técnico en Contaduría Pública',
                'facultad' => 'Facultad de Ciencias Económicas',
                'nivel'    => 'pregrado',
                'codigo'   => 'TCP'
            ],

            // --- Facultad de Ciencias y Humanidades (Pregrado) ---
            [
                'nombre'   => 'Licenciatura en Psicología',
                'facultad' => 'Facultad de Ciencias y Humanidades',
                'nivel'    => 'pregrado',
                'codigo'   => 'LPSI'
            ],
            [
                'nombre'   => 'Licenciatura en Ciencias de la Educación con especialidad en Lenguaje y Literatura',
                'facultad' => 'Facultad de Ciencias y Humanidades',
                'nivel'    => 'pregrado',
                'codigo'   => 'LLE'
            ],
            [
                'nombre'   => 'Licenciatura en Ciencias de la Educación con especialidad en Idioma Inglés',
                'facultad' => 'Facultad de Ciencias y Humanidades',
                'nivel'    => 'pregrado',
                'codigo'   => 'LING'
            ],

            // --- Facultad de Jurisprudencia y Ciencias Sociales (Pregrado) ---
            [
                'nombre'   => 'Licenciatura en Ciencias Jurídicas',
                'facultad' => 'Facultad de Jurisprudencia y Ciencias Sociales',
                'nivel'    => 'pregrado',
                'codigo'   => 'DER'
            ],

            // --- Escuela de Posgrado (Posgrado) ---
            [
                'nombre'   => 'Maestría en Docencia Universitaria',
                'facultad' => 'Escuela de Posgrado',
                'nivel'    => 'posgrado',
                'codigo'   => 'MDU'
            ],
            [
                'nombre'   => 'Maestría en Derecho Procesal Civil y Mercantil',
                'facultad' => 'Escuela de Posgrado',
                'nivel'    => 'posgrado',
                'codigo'   => 'MDPCM'
            ],
        ];

        foreach ($carreras as $carrera) {
            Carrera::updateOrCreate(
                ['nombre' => $carrera['nombre']],
                $carrera
            );
        }
    }
}
