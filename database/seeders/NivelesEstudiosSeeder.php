<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelesEstudiosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pfp_niveles_estudios')->upsert(
            [
                ['nivel_estudios' => 'Licenciatura', 'created_at' => now(), 'updated_at' => now()],
                ['nivel_estudios' => 'Maestría',     'created_at' => now(), 'updated_at' => now()],
                ['nivel_estudios' => 'Especialidad', 'created_at' => now(), 'updated_at' => now()],
                ['nivel_estudios' => 'Doctorado',    'created_at' => now(), 'updated_at' => now()],
            ],
            ['nivel_estudios'],      // clave lógica única
            ['updated_at']           // qué actualizar si ya existe
        );
    }
}

