<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transacciones_puntos', function (Blueprint $table) {
            $table->id('transaccion_id');
            $table->foreignId('fidelizacion_id')->constrained('fidelizacion')->onDelete('cascade');
            $table->integer('puntos');
            $table->enum('tipo', ['ganado', 'usado']);
            $table->string('motivo');
            $table->timestamp('fecha_transaccion')->useCurrent();
            $table->foreignId('pedido_id')->nullable()->constrained('pedidos')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacciones_puntos');
    }
};
