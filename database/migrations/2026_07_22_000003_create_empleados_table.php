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
        Schema::create('empleados', function (Blueprint $table) {
            $table->integer('id_empleados')->autoIncrement();
            $table->string('nombre', 30);
            $table->string('telefono', 15)->nullable();
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
        Schema::dropIfExists('empleados');
    }
};
