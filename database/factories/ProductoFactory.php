<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->words(2, true),
            'descripcion' => fake()->sentence(),
            'categoria_id' => Categoria::factory(),
            'precio_base' => fake()->randomFloat(2, 5, 50),
            'imagen_url' => fake()->imageUrl(),
            'disponible' => true,
            'es_personalizado' => fake()->boolean(),
            'tiempo_preparacion' => fake()->numberBetween(5, 30),
        ];
    }
}
