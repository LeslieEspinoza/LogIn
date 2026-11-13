<?php

namespace Database\Factories;

use App\Models\Carrera;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EstudianteFactory extends Factory
{
    protected $model = Estudiante::class;

    public function definition(): array
    {
        return [
            'documento_identidad' => $this->faker->word(),
            'nombres' => $this->faker->word(),
            'correo_institucional' => $this->faker->word(),
            'estatus_financiero' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'carrera_id' => Carrera::factory(),
        ];
    }
}
