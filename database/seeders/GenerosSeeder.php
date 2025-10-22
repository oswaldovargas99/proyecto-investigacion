<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenerosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pfp_generos')->upsert(
            [
                ['genero' => 'Masculino',  'created_at' => now(), 'updated_at' => now()],
                ['genero' => 'Femenino',   'created_at' => now(), 'updated_at' => now()],
                ['genero' => 'No Binario', 'created_at' => now(), 'updated_at' => now()],
            ],
            ['genero'],        // clave única
            ['updated_at']     // columnas a actualizar si existe
        );
    }
}
