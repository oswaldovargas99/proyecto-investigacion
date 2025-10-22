<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesAcademicosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pfp_niveles_academicos')->upsert(
            [
                ['nivel_academico' => 'Maestría',    'created_at' => now(), 'updated_at' => now()],
                ['nivel_academico' => 'Especialidad','created_at' => now(), 'updated_at' => now()],
                ['nivel_academico' => 'Doctorado',   'created_at' => now(), 'updated_at' => now()],
            ],
            ['nivel_academico'],   // clave única lógica
            ['updated_at']         // columnas a actualizar si ya existe
        );
    }
}
