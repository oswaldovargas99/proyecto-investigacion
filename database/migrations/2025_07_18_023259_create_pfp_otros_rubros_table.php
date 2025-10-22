<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pfp_otros_rubros', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('rubro', 100);  // ej. "Material didáctico", "Impresión", etc.
            $table->string('concepto');    // descripción breve del concepto
            $table->decimal('monto', 10, 2);
        });
    }

    public function down(): void {
        Schema::dropIfExists('pfp_otros_rubros');
    }
};
