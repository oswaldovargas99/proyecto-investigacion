<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pfp_informes', function (Blueprint $table) {
            $table->id();

            // Usuario dueño del informe
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Fecha del informe (obligatoria)
            $table->date('fecha');

            // Relación: Categoría Mejora -> Criterio SNP
            $table->foreignId('categoria_mejora_id')
                  ->constrained('pfp_categorias_mejoras')
                  ->cascadeOnDelete();

            $table->foreignId('criterio_snp_id')
                  ->constrained('pfp_criterios_snp')
                  ->cascadeOnDelete();

            // Campos de contenido (requeridos)
            $table->text('impacto_academico');
            $table->text('concepto_gasto');
            $table->text('actividad_realizada');

            // Beneficiarios (requeridos)
            $table->foreignId('tipo_beneficiario_id')
                  ->constrained('pfp_tipos_beneficiarios')
                  ->cascadeOnDelete();

            $table->integer('numero_beneficiario');
            $table->decimal('monto_destinado', 10, 2);

            // Comentarios (opcional)
            $table->text('comentarios')->nullable();

            // Archivo (ruta del PDF firmado, opcional)
            $table->string('informe_firmado')->nullable();

            $table->timestamps();

            // Índices útiles para filtros
            $table->index(['user_id', 'fecha']);
            $table->index(['categoria_mejora_id', 'criterio_snp_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pfp_informes');
    }
};
