<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfesorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombres'   => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'email'     => $this->faker->unique()->safeEmail(),
            'telefono'  => '7' . $this->faker->randomNumber(7, true),
        ];
    }
}
