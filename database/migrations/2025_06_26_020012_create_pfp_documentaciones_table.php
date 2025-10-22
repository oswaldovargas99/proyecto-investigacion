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
        Schema::create('pfp_documentaciones', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('usuario_id');
                $table->string('acta_junta')->nullable();
                $table->string('carta_no_adeudo')->nullable();
                $table->string('p3e')->nullable();
                $table->string('solicitud_firmado')->nullable();
                $table->string('informe_firmado')->nullable();
                $table->timestamps();

                $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pfp_documentaciones');
    }
};


