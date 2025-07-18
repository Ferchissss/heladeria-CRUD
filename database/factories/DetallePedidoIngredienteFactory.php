<?php

namespace Database\Factories;

use App\Models\DetallePedido;
use App\Models\Ingrediente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetallePedidoIngrediente>
 */
class DetallePedidoIngredienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'detalle_id' => DetallePedido::factory(),
            'ingrediente_id' => Ingrediente::factory(),
            'es_extra' => fake()->boolean(),
        ];
    }
}
