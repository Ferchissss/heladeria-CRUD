<?php

namespace Database\Factories;

use App\Models\Ingrediente;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductoIngrediente>
 */
class ProductoIngredienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => Producto::factory(),
            'ingrediente_id' => Ingrediente::factory(),
            'es_default' => fake()->boolean(70), // 70% de probabilidad de ser ingrediente predeterminado
        ];
    }
}
