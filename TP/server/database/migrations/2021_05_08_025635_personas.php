<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Personas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 10)->unique()->collation('utf8mb4_bin');
            $table->string('imagen_dni', 50)->unique()->nullable();
            $table->string('nombre_usuario', 30)->unique()->collation('utf8mb4_bin');
            $table->string('clave', 180)->collation('utf8mb4_bin');
            $table->string('nombre_apellido', 60);
            $table->string('email', 60);
            $table->string('telefono', 14);
            $table->string('api_token', 120)->unique()->nullable()->collation('utf8mb4_bin');
            $table->string('curriculum_vitae', 50)->unique()->nullable();
            $table->boolean('verificada');
            $table->string('codigo_cambiar_clave')->unique()->nullable()->collation('utf8mb4_bin');
            $table->dateTime('fecha_hora_max_cambiar_clave')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
}
