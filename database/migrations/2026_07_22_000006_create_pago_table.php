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
        Schema::create('pago', function (Blueprint $table) {
            $table->integer('id_pago')->autoIncrement();
            $table->string('fecha_pago', 20);
            $table->string('metodo_pago', 25);
            $table->decimal('valor_pagado', 10, 0)->nullable();
            $table->integer('id_reserva');

            $table->foreign('id_reserva')
                  ->references('id_reserva')
                  ->on('reserva')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago');
    }
};
