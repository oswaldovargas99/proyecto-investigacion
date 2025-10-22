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
        Schema::create('pfp_coordinadores', function (Blueprint $table) {
            $table->id();

            // Datos base del coordinador
            $table->string('codigo', 50)->unique();     // Código único del coordinador
            $table->string('nombre_coordinador');       // Nombre completo del coordinador

            // Relación con users (ahora N:1, varios coordinadores pueden estar ligados a un mismo usuario)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            // Relación con Centros Universitarios
            $table->unsignedBigInteger('centro_universitario_id');
            $table->foreign('centro_universitario_id')
                  ->references('id')
                  ->on('pfp_centros_universitarios')
                  ->onDelete('cascade');

            // Relación con Posgrados
            $table->unsignedBigInteger('posgrado_id');
            $table->foreign('posgrado_id')
                  ->references('id')
                  ->on('pfp_posgrados')
                  ->onDelete('cascade');

            // Relación con Niveles de Estudio
            $table->unsignedBigInteger('nivel_estudios_id');
            $table->foreign('nivel_estudios_id')
                  ->references('id')
                  ->on('pfp_niveles_estudios')
                  ->onDelete('cascade');

            // Relación con Géneros
            $table->unsignedBigInteger('genero_id');
            $table->foreign('genero_id')
                  ->references('id')
                  ->on('pfp_generos')
                  ->onDelete('cascade');

            // Fecha de nacimiento
            $table->date('fecha_nacimiento');

            // Datos de contacto
            $table->string('correo_institucional')->unique();
            $table->string('correo_alternativo')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('extension', 10)->nullable();
            $table->string('celular', 20)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pfp_coordinadores');
    }
};
