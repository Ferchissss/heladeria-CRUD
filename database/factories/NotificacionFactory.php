<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notificacion>
 */
class NotificacionFactory extends Factory
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
            'titulo' => fake()->sentence(3),
            'mensaje' => fake()->paragraph(),
            'tipo' => fake()->randomElement(['promocion', 'nuevo_sabor', 'pedido', 'fidelizacion']),
            'leida' => fake()->boolean(),
            'url_destino' => fake()->url(),
        ];  
    }
}
