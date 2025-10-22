<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalidadesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pfp_modalidades')->upsert(
            [
                ['modalidad' => 'Escolarizada',                 'descripcion' => 'Modalidad presencial con asistencia regular a clases.',                                 'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'No Escolarizada',              'descripcion' => 'Modalidad sin asistencia regular, basada en el autoaprendizaje.',                   'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'Semiescolarizada',             'descripcion' => 'Modalidad con combinación de actividades presenciales y no presenciales.',         'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'Mixta',                        'descripcion' => 'Combina clases presenciales y a distancia.',                                      'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'Escolarizada y Mixta',         'descripcion' => 'Integra clases presenciales regulares y componentes mixtos.',                      'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'A distancia',                  'descripcion' => 'Modalidad totalmente en línea, sin clases presenciales.',                          'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'Escolarizada y A Distancia',   'descripcion' => 'Mezcla entre asistencia presencial y actividades en línea.',                       'created_at' => now(), 'updated_at' => now()],
                ['modalidad' => 'Mixta (Tutorial y A Distancia)','descripcion' => 'Modalidad que incluye tutorías personalizadas y actividades a distancia.',        'created_at' => now(), 'updated_at' => now()],
            ],
            ['modalidad'],                 // clave única lógica
            ['descripcion','updated_at']   // columnas a actualizar si ya existe
        );
    }
}
