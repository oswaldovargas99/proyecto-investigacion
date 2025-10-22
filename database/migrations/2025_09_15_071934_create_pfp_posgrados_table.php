<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pfp_posgrados', function (Blueprint $table) {
            $table->id();

            // Datos del posgrado (catálogo)
            $table->string('clave_snp')->unique();   // clave única del programa
            $table->string('nombre_posgrado');       // nombre visible en selects

            // Relación con Centros Universitarios
            $table->unsignedBigInteger('centro_universitario_id');
            $table->foreign('centro_universitario_id')
                  ->references('id')->on('pfp_centros_universitarios')
                  ->onDelete('cascade');

            // Relación con Niveles Académicos
            $table->unsignedBigInteger('nivel_academico_id');
            $table->foreign('nivel_academico_id')
                  ->references('id')->on('pfp_niveles_academicos')
                  ->onDelete('cascade');

            // Relación con Orientaciones
            $table->unsignedBigInteger('orientacion_posgrado_id');
            $table->foreign('orientacion_posgrado_id')
                  ->references('id')->on('pfp_orientaciones')
                  ->onDelete('cascade');

            // Relación con Modalidades
            $table->unsignedBigInteger('modalidad_posgrado_id');
            $table->foreign('modalidad_posgrado_id')
                  ->references('id')->on('pfp_modalidades')
                  ->onDelete('cascade');

            // Índices útiles (opcional)
            $table->index(['centro_universitario_id']);
            $table->index(['nivel_academico_id']);
            $table->index(['orientacion_posgrado_id']);
            $table->index(['modalidad_posgrado_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_posgrados');
    }
};
