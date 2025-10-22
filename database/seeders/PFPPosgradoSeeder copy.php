<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PosgradoSeeder extends Seeder
{
    public function run(): void
    {
        $posgrados = [
            [
                'clave_snp' => 'SNP-001',
                'nombre_posgrado' => 'Maestría en Ciencias Sociales',
                'centro_universitario_id' => 1,
                'nivel_academico_id' => 1,
                'orientacion_posgrado_id' => 1,
                'modalidad_posgrado_id' => 1,
            ],
            [
                'clave_snp' => 'SNP-002',
                'nombre_posgrado' => 'Especialidad en Derecho Penal',
                'centro_universitario_id' => 2,
                'nivel_academico_id' => 2,
                'orientacion_posgrado_id' => 2,
                'modalidad_posgrado_id' => 1,
            ],
            [
                'clave_snp' => 'SNP-003',
                'nombre_posgrado' => 'Doctorado en Ingeniería',
                'centro_universitario_id' => 3,
                'nivel_academico_id' => 3,
                'orientacion_posgrado_id' => 1,
                'modalidad_posgrado_id' => 2,
            ],
            [
                'clave_snp' => 'SNP-004',
                'nombre_posgrado' => 'Maestría en Educación',
                'centro_universitario_id' => 1,
                'nivel_academico_id' => 1,
                'orientacion_posgrado_id' => 2,
                'modalidad_posgrado_id' => 1,
            ],
            [
                'clave_snp' => 'SNP-005',
                'nombre_posgrado' => 'Especialidad en Tecnologías de la Información',
                'centro_universitario_id' => 2,
                'nivel_academico_id' => 2,
                'orientacion_posgrado_id' => 1,
                'modalidad_posgrado_id' => 2,
            ],
        ];

        foreach ($posgrados as $data) {
            DB::table('pfp_posgrados')->updateOrInsert(
                ['clave_snp' => $data['clave_snp']], // evita duplicados por clave única
                array_merge($data, [
                    'user_id'                 => $userId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ])
            );
        }
    }
}
