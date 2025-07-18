<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingrediente>
 */
class IngredienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->word(),
            'descripcion' => fake()->sentence(),
            'precio_extra' => fake()->randomFloat(2, 0.5, 5),
            'disponible' => true,
            'tipo' => fake()->randomElement(['sabor', 'cobertura', 'topping', 'base']),
            'imagen_url' => fake()->imageUrl(),
        ];
    }
}
