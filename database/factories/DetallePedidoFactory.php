<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Promocion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetallePedido>
 */
class DetallePedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pedido_id' => Pedido::factory(),
            'producto_id' => Producto::factory(),
            'cantidad' => fake()->numberBetween(1, 3),
            'precio_unitario' => fake()->randomFloat(2, 5, 20),
            'subtotal' => fake()->randomFloat(2, 10, 50),
            'instrucciones_especiales' => fake()->sentence(),
            'promocion_id' => Arr::random([null, Promocion::factory()]),
        ];
    }
}
