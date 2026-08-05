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
        Schema::create('reserva', function (Blueprint $table) {
            $table->integer('id_reserva')->autoIncrement();
            $table->string('fecha', 20);
            $table->string('hora', 10);
            $table->string('estado', 25)->default('pendiente');
            $table->integer('id_cliente');
            $table->integer('id_servicio');
            $table->integer('id_empleados')->nullable();

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('cliente')
                  ->onDelete('cascade');

            $table->foreign('id_servicio')
                  ->references('id_servicio')
                  ->on('servicio')
                  ->onDelete('cascade');

            $table->foreign('id_empleados')
                  ->references('id_empleados')
                  ->on('empleados')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserva');
    }
};
