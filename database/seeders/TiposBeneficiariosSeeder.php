<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TiposBeneficiariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'tipo' => 'Estudiantes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tipo' => 'Profesores',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tipo' => 'Programa de Posgrado',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'tipo' => 'Otros',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('pfp_tipos_beneficiarios')->insert($tipos);
    }
}


