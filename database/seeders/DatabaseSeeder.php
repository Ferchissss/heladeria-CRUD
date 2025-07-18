<?php

namespace Database\Seeders;

use App\Models\Notificacion;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        $this->call([
            ClienteSeeder::class,
            CategoriaSeeder::class,
            DetallePedidoIngredienteSeeder::class,
            ProductoSeeder::class,
            IngredienteSeeder::class,
            ProductoIngredienteSeeder::class,
            PedidoSeeder::class,
            DetallePedidoSeeder::class,
            PromocionSeeder::class,
            FidelizacionSeeder::class,
            TransaccionPuntoSeeder::class,
            NotificacionSeeder::class,
        ]);
    }
}
