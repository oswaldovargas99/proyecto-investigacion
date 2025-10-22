<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_categorias_mejoras', function (Blueprint $table) {
            $table->id();
            $table->string('categoria');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_categorias_mejoras');
    }
};

