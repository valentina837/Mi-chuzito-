<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventarios', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('producto_id');

            $table->foreign('producto_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->integer('cantidad');

            $table->integer('nivel_minimo')
                ->default(5);

            $table->enum('estado', [
                'Disponible',
                'Agotado'
            ])->default('Disponible');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
