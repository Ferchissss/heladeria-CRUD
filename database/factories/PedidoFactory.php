<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
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
            'estado' => fake()->randomElement(['pendiente', 'preparando', 'entregado', 'cancelado']),
            'total' => fake()->randomFloat(2, 10, 100),
            'direccion_entrega' => fake()->address(),
            'metodo_pago' => fake()->randomElement(['efectivo', 'tarjeta', 'transferencia']),
            'notas' => fake()->sentence(),
        ];
    }
}
