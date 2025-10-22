<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pfp_datos_generales', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();

            // ===== DATOS DEL POSGRADO =====
            $table->unsignedBigInteger('centro_universitario_id');
            $table->unsignedBigInteger('posgrado_id')->nullable();   // ← nullable, acorde a tu validación
            $table->unsignedBigInteger('nivel_academico_id');
            $table->unsignedBigInteger('orientacion_id');
            $table->unsignedBigInteger('modalidad_id');

            // ===== DATOS DEL COORDINADOR =====
            $table->string('codigo', 50)->index();
            $table->string('clave_snp', 50)->nullable();
            $table->string('nombre_coordinador', 200);
            $table->string('correo_institucional', 180);
            $table->string('correo_alternativo', 180)->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('extension', 10)->nullable();
            $table->string('celular', 30)->nullable();

            // ===== DATOS DEL ASISTENTE =====
            $table->string('nombre_asistente', 200)->nullable();
            $table->date('fecha_nacimiento_asistente')->nullable();   // NUEVO
            $table->unsignedBigInteger('genero_id')->nullable();      // NUEVO (FK a pfp_generos)
            $table->string('correo_asistente', 180)->nullable();
            $table->string('telefono_asistente', 30)->nullable();
            $table->string('extension_asistente', 10)->nullable();
            $table->string('celular_asistente', 30)->nullable();

            $table->timestamps();
        });

        // Agregar FKs en bloque separado y de forma condicional (evita error 150)
        Schema::table('pfp_datos_generales', function (Blueprint $table) {

            if (Schema::hasTable('pfp_centros_universitarios')) {
                $table->foreign('centro_universitario_id', 'fk_dg_cu')
                      ->references('id')->on('pfp_centros_universitarios')
                      ->restrictOnDelete();
            }

            // 👇 NUEVO: FK posgrado
            if (Schema::hasTable('pfp_posgrados')) {
                $table->foreign('posgrado_id', 'fk_dg_posgrado')
                      ->references('id')->on('pfp_posgrados')
                      ->nullOnDelete(); // si borran el posgrado, queda NULL
            }

            if (Schema::hasTable('pfp_niveles_academicos')) {
                $table->foreign('nivel_academico_id', 'fk_dg_nivel_academico')
                      ->references('id')->on('pfp_niveles_academicos')
                      ->restrictOnDelete();

            } elseif (Schema::hasTable('pfp_niveles_posgrados')) {
                $table->foreign('nivel_academico_id', 'fk_dg_nivel_posgrado')
                      ->references('id')->on('pfp_niveles_posgrados')
                      ->restrictOnDelete();
            }

            if (Schema::hasTable('pfp_orientaciones')) {
                $table->foreign('orientacion_id', 'fk_dg_orientacion')
                      ->references('id')->on('pfp_orientaciones')
                      ->restrictOnDelete();
            }

            if (Schema::hasTable('pfp_modalidades')) {
                $table->foreign('modalidad_id', 'fk_dg_modalidad')
                      ->references('id')->on('pfp_modalidades')
                      ->restrictOnDelete();
            }

            // FK género
            if (Schema::hasTable('pfp_generos')) {
                $table->foreign('genero_id', 'fk_dg_genero')
                      ->references('id')->on('pfp_generos')
                      ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pfp_datos_generales', function (Blueprint $table) {
            foreach ([
                'fk_dg_cu',
                'fk_dg_posgrado',          // ← drop FK agregado
                'fk_dg_nivel_academico',
                'fk_dg_nivel_posgrado',
                'fk_dg_orientacion',
                'fk_dg_modalidad',
                'fk_dg_genero',
            ] as $fk) {
                try { $table->dropForeign($fk); } catch (\Throwable $e) {}
            }
        });

        Schema::dropIfExists('pfp_datos_generales');
    }
};
