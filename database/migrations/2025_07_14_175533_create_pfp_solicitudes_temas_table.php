<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_solicitudes_temas', function (Blueprint $table) {
            $table->id();

            // Claves foráneas
            $table->foreignId('solicitud_id')
                  ->constrained('pfp_solicitudes')
                  ->onDelete('cascade');

            $table->foreignId('tema_id')
                  ->constrained('pfp_temas')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_solicitudes_temas');
    }
};
