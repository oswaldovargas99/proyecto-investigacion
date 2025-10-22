<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pfp_centros_universitarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_rector');
            $table->string('tipo_centro_universitario');
            $table->string('centro_universitario');
            $table->string('siglas', 50);
            $table->string('direccion');
            $table->string('telefonos');
            $table->string('sitio_web')->nullable();
            $table->string('colonia', 100)->nullable();       // ✅ corregido
            $table->string('codigo_postal', 10)->nullable();  // ✅ corregido
            $table->string('municipio');
            $table->string('estado');
            $table->string('pais');
            $table->boolean('vigente')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pfp_centros_universitarios');
    }
};
