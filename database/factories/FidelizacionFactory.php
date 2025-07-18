<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fidelizacion>
 */
class FidelizacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'puntos_acumulados' => fake()->numberBetween(0, 1000),
            'nivel' => fake()->randomElement(['bronce', 'plata', 'oro']),
        ];
    }
}
