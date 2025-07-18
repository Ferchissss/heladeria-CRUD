<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promocion>
 */
class PromocionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Creamos items aleatorios para el combo (productos e ingredientes)
        $items = [
            [
                'tipo' => 'producto',
                'id' => $this->faker->numberBetween(1, 20), // IDs de productos simulados
                'cantidad' => $this->faker->numberBetween(1, 5),
            ],
            [
                'tipo' => 'ingrediente',
                'id' => $this->faker->numberBetween(1, 10), // IDs de ingredientes simulados
                'cantidad' => $this->faker->numberBetween(1, 3),
            ],
        ];

        return [
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->paragraph(),
            'tipo' => fake()->randomElement(['porcentaje', 'monto', 'combo', 'happy_hour', 'primera_compra', 'cumpleaños', 'desbloqueable']),
            'descuento_porcentaje' => fake()->randomFloat(2, 5, 30),
            'descuento_monto' => fake()->randomFloat(2, 5, 20),
            'fecha_inicio' => fake()->dateTimeBetween('-1 month', '+1 month'),
            'fecha_fin' => fake()->dateTimeBetween('+1 month', '+3 months'),
            'dias_aplicables' => json_encode(fake()->randomElements(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'], fake()->numberBetween(1, 7))),
            'aplica_solo_primera_compra' => fake()->boolean(),
            'aplica_en_cumpleanos' => fake()->boolean(),
            'compras_requeridas' => fake()->numberBetween(0, 5),
            'activa' => true,
            'combo_detalle' => json_encode([
                'items' => $items,
                'precio_combo' => $this->faker->randomFloat(2, 20, 50),
            ]),
        ];
    }
}
