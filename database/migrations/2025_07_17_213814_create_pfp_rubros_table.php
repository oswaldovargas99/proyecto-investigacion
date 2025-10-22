<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_rubros', function (Blueprint $table) {
            // Asegura InnoDB (FKs requieren InnoDB en MySQL/MariaDB)
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('rubro', 50)->unique();  // Ej: 2111
            $table->string('concepto');             // Ej: "Materiales, útiles..."
            $table->unsignedBigInteger('categoria_id')->nullable(); // se indexa y la FK se agrega luego
            $table->timestamps();

            $table->index('categoria_id'); // índice para la futura FK
            $table->index('concepto');     // opcional, útil para búsquedas
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_rubros');
    }
};
