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
        Schema::create('detalle_servicio', function (Blueprint $table) {
            $table->integer('id_detalle_servicio')->autoIncrement();
            $table->string('cantidad', 20);
            $table->decimal('precio_unitario', 10, 0)->nullable();
            $table->decimal('subtotal', 10, 0)->nullable();
            $table->integer('id_reserva');
            $table->integer('id_servicio');

            $table->foreign('id_reserva')
                  ->references('id_reserva')
                  ->on('reserva')
                  ->onDelete('cascade');

            $table->foreign('id_servicio')
                  ->references('id_servicio')
                  ->on('servicio')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_servicio');
    }
};
