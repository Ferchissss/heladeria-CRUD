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
        Schema::create('promociones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->enum('tipo', ['porcentaje', 'monto', 'combo', 'happy_hour', 'primera_compra', 'cumpleaños', 'desbloqueable'])->default('porcentaje');
            $table->decimal('descuento_porcentaje', 5, 2)->nullable();
            $table->decimal('descuento_monto', 10, 2)->nullable();
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->json('dias_aplicables')->nullable();
            $table->boolean('aplica_solo_primera_compra')->default(false);
            $table->boolean('aplica_en_cumpleanos')->default(false);
            $table->integer('compras_requeridas')->default(0);
            $table->boolean('activa')->default(true);
            $table->json('combo_detalle')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promociones');
    }
};
