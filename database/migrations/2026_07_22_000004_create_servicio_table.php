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
        Schema::create('servicio', function (Blueprint $table) {
            $table->integer('id_servicio')->autoIncrement();
            $table->string('nombre_servicio', 30);
            $table->string('descripcion', 255)->nullable();
            $table->decimal('precio', 10, 0)->nullable();
            $table->integer('id_administrador');

            $table->foreign('id_administrador')
                  ->references('id_administrador')
                  ->on('administrador')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicio');
    }
};
