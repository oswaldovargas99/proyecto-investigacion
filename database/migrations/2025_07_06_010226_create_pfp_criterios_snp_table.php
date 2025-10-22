<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_criterios_snp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_mejora_id')
                  ->constrained('pfp_categorias_mejoras')
                  ->cascadeOnDelete();
            $table->string('nombre'); // consistente con el modelo
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_criterios_snp');
    }
};
