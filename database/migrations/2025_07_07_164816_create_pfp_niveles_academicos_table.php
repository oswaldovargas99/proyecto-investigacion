<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_niveles_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nivel_academico');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_niveles_academicos');
    }
};


