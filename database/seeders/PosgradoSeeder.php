<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class PosgradoSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica que existan datos en catálogos requeridos
        $required = [
            'pfp_centros_universitarios',
            'pfp_niveles_academicos',
            'pfp_orientaciones',
            'pfp_modalidades',
        ];
        foreach ($required as $tabla) {
            if (!DB::table($tabla)->exists()) {
                throw new \RuntimeException("La tabla {$tabla} no tiene registros. Ejecuta primero sus seeders.");
            }
        }

        // Obtiene IDs disponibles de catálogos
        $centros       = DB::table('pfp_centros_universitarios')->pluck('id')->all();
        $niveles       = DB::table('pfp_niveles_academicos')->pluck('id')->all();
        $orientaciones = DB::table('pfp_orientaciones')->pluck('id')->all();
        $modalidades   = DB::table('pfp_modalidades')->pluck('id')->all();

        if (!$centros || !$niveles || !$orientaciones || !$modalidades) {
            throw new \RuntimeException("Faltan registros en alguno de los catálogos requeridos.");
        }

        // Limpia tabla de posgrados
        Schema::disableForeignKeyConstraints();
        DB::table('pfp_posgrados')->truncate();
        Schema::enableForeignKeyConstraints();

        // Posgrados de ejemplo (sin user_id)
        $base = [
            ['clave_snp' => 'SNP-001', 'nombre_posgrado' => 'Maestría en Ciencias de la Educación'],
            ['clave_snp' => 'SNP-002', 'nombre_posgrado' => 'Doctorado en Derecho Constitucional'],
            ['clave_snp' => 'SNP-003', 'nombre_posgrado' => 'Maestría en Ingeniería de Software'],
            ['clave_snp' => 'SNP-004', 'nombre_posgrado' => 'Especialidad en Salud Pública'],
            ['clave_snp' => 'SNP-005', 'nombre_posgrado' => 'Doctorado en Ciencias Sociales'],
        ];

        $now = Carbon::now();
        $rows = [];
        foreach ($base as $row) {
            $rows[] = [
                'clave_snp'               => $row['clave_snp'],
                'nombre_posgrado'         => $row['nombre_posgrado'],
                'centro_universitario_id' => $centros[array_rand($centros)],
                'nivel_academico_id'      => $niveles[array_rand($niveles)],
                'orientacion_posgrado_id' => $orientaciones[array_rand($orientaciones)],
                'modalidad_posgrado_id'   => $modalidades[array_rand($modalidades)],
                'created_at'              => $now,
                'updated_at'              => $now,
            ];
        }

        DB::table('pfp_posgrados')->insert($rows);
    }
}
