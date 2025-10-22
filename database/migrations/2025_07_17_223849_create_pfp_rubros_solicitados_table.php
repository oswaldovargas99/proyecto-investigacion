<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_rubros_solicitados', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('rubro', 50);    // clave del rubro, ej. 2111
            $table->string('concepto');     // snapshot del nombre/descr. visible
            $table->decimal('monto', 10, 2);

            $table->timestamps();

            $table->unique(['user_id', 'rubro']);
            $table->index('rubro');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_rubros_solicitados');
    }
};
