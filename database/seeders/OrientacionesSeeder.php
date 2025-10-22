<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrientacionesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pfp_orientaciones')->upsert(
            [
                [
                    'orientacion' => 'Investigación',
                    'descripcion' => 'El posgrado con orientación a la investigación.',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'orientacion' => 'Profesionalizante',
                    'descripcion' => 'Los posgrados de orientación profesional en los niveles de especialidad o de maestría.',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
            ],
            ['orientacion'],           // clave única lógica
            ['descripcion','updated_at'] // columnas a actualizar si ya existe
        );
    }
}
