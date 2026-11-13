<?php

namespace Database\Factories;

use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Materia>
 */
class MateriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Materia::class;
    public function definition(): array
    {
        return [
            'codigo' => fake() -> word(15, true),
            'nombre' => fake() -> word,
            'semestre_nivel' => fake() -> numberBetween(1, 10),
            'creditos' => fake() -> numberBetween(1, 5),
        ];
    }
}
