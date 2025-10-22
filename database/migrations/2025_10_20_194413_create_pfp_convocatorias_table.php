<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pfp_convocatorias', function (Blueprint $table) {
            $table->id();

            // 🔗 Relación con la tabla users (1:N)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            // 🧾 Campos principales
            $table->string('nombre_convocatoria', 255);
            $table->string('lema', 255)->nullable();
            $table->string('responsable', 255)->nullable();
            $table->string('cargo', 255)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('anio', 4);

            // ⚙️ Estado de la convocatoria (1 = activa, 0 = inactiva)
            $table->boolean('id_status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pfp_convocatorias');
    }
};




