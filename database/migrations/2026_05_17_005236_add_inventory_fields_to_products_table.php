<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->integer('stock')->default(0);

            $table->integer('minimum_stock')->default(5);

            $table->string('status')->default('Disponible');

        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn([
                'stock',
                'minimum_stock',
                'status'
            ]);

        });
    }
};