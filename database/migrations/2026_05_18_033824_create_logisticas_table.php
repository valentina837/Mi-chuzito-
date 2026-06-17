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
        Schema::create('logisticas', function (Blueprint $table) {

            $table->id();

            // Pedido relacionado
            $table->foreignId('pedido_id')
                ->constrained('orders')
                ->onDelete('cascade');

            // Repartidor único
            $table->string('repartidor_nombre');

            $table->string('repartidor_telefono');

            $table->string('ubicacion_repartidor')
                ->nullable();

            // Cliente
            $table->string('ubicacion_cliente');

            // Ruta
            $table->text('ruta_sugerida')
                ->nullable();

            // Estado
            $table->enum('estado', [
                'asignado',
                'en_camino',
                'entregado'
            ])->default('asignado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logisticas');
    }
};
