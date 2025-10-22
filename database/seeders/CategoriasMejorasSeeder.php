<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoriasMejorasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $rows = [
            ['categoria' => 'Compromiso Institucional (CI)'],
            ['categoria' => 'Estructura del Programa Académico (EPA)'],
            ['categoria' => 'Desarrollo del Talento (DT)'],
            ['categoria' => 'Producción y Efectos (PE)'],
            ['categoria' => 'Resultados y Vinculación (RV)'],
        ];

        foreach ($rows as $row) {
            DB::table('pfp_categorias_mejoras')->updateOrInsert(
                ['categoria' => $row['categoria']],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
