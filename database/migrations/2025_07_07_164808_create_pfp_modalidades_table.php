<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pfp_modalidades', function (Blueprint $table) {
            $table->id();
            $table->string('modalidad');       // 🆕 Campo modalidad
            $table->string('descripcion')->nullable(); // 🆕 Campo descripción opcional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_modalidades');
    }
};

