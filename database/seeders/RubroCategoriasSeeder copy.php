<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubroCategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            [
                'categoria'   => '2000 - MATERIALES Y SUMINISTROS',
                'descripcion' => 'Insumos y materiales diversos para operación.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'categoria'   => '3000 - SERVICIOS GENERALES',
                'descripcion' => 'Servicios básicos, mantenimiento, difusión, viáticos, etc.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'categoria'   => '5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES',
                'descripcion' => 'Adquisición de equipo, mobiliario, software y afines.',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        // Requiere un índice único sobre 'categoria' para que el upsert funcione como se espera
        // (puedes habilitarlo en la migración con: $table->unique('categoria');).
        DB::table('pfp_rubros_categorias')->upsert(
            $rows,
            ['categoria'],                 // uniqueBy
            ['descripcion', 'updated_at']  // columns to update si ya existe
        );
    }
}
