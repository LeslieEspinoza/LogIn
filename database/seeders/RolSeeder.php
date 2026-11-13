<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        // insertOrIgnore evita duplicados si el seeder se ejecuta varias veces
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nombre' => 'Docente',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nombre' => 'Estudiante',    'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
