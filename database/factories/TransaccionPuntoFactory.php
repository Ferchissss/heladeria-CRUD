<?php

namespace Database\Factories;

use App\Models\Fidelizacion;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaccionPunto>
 */
class TransaccionPuntoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fidelizacion_id' => Fidelizacion::factory(),
            'puntos' => fake()->numberBetween(10, 100),
            'tipo' => fake()->randomElement(['ganado', 'usado']),
            'motivo' => fake()->sentence(),
            'pedido_id' => Pedido::factory(),
        ];
    }
}
