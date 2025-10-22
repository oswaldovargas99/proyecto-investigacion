<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pfp_rubros_categorias', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');            // Ej: "MATERIALES Y SUMINISTROS" o "2000 - MATERIALES..."
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Opcionalmente: $table->unique('categoria'); // si asegurarás unicidad por nombre
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_rubros_categorias');
    }
};
