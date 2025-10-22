<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CentroUniversitario;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CentroUniversitarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        // Lista según lo solicitado (siglas => nombre)
        $raw = [
            ['siglas' => 'CUAAD',         'centro_universitario' => 'Centro Universitario de Arte, Arquitectura y Diseño'],
            ['siglas' => 'CUCBA',         'centro_universitario' => 'Centro Universitario de Ciencias Biológicas y Agropecuarias'],
            ['siglas' => 'CUCEA',         'centro_universitario' => 'Centro Universitario de Ciencias Económico Administrativas'],
            ['siglas' => 'CUCEI',         'centro_universitario' => 'Centro Universitario de Ciencias Exactas e Ingenierías'],
            ['siglas' => 'CUCS',          'centro_universitario' => 'Centro Universitario de Ciencias de la Salud'],
            ['siglas' => 'CUCSH',         'centro_universitario' => 'Centro Universitario de Ciencias Sociales y Humanidades'],
            ['siglas' => 'CUGDL',         'centro_universitario' => 'Centro Universitario de Guadalajara'],
            ['siglas' => 'CUALTOS',       'centro_universitario' => 'Centro Universitario de los Altos'],
            ['siglas' => 'CUCHAPALA',     'centro_universitario' => 'Centro Universitario de Chapala'],
            ['siglas' => 'CUCIENEGA',     'centro_universitario' => 'Centro Universitario de La Ciénega'],
            ['siglas' => 'CUCOSTA',       'centro_universitario' => 'Centro Universitario de la Costa'],
            ['siglas' => 'CUCSUR',        'centro_universitario' => 'Centro Universitario de la Costa Sur'],
            ['siglas' => 'CULAGOS',       'centro_universitario' => 'Centro Universitario de los Lagos'],
            ['siglas' => 'CUNORTE',       'centro_universitario' => 'Centro Universitario del Norte'],
            ['siglas' => 'CUSUR',         'centro_universitario' => 'Centro Universitario del Sur'],
            ['siglas' => 'CUTLAJO',       'centro_universitario' => 'Centro Universitario de Tlajomulco'],
            ['siglas' => 'CUTLAQUEPAQUE', 'centro_universitario' => 'Centro Universitario de Tlaquepaque'],
            ['siglas' => 'CUTONALÁ',      'centro_universitario' => 'Centro Universitario de Tonalá'],
            ['siglas' => 'CUVALLES',      'centro_universitario' => 'Centro Universitario de los Valles'],
        ];

        // Orden alfabético por siglas
        usort($raw, fn($a, $b) => strcmp($a['siglas'], $b['siglas']));

        $tipos = [
            'Centro Universitario Metropolitano',
            'Centro Universitario Regional',
            'Centro Universitario Temático',
        ];

        foreach ($raw as $item) {
            $siglas = strtoupper($item['siglas']);
            $nombre = $item['centro_universitario'];

            // slug ascii para URL (quita acentos: CUTONALÁ -> cutonala)
            $slug = Str::of($siglas)->ascii()->lower();

            $data = [
                'nombre_rector'             => $faker->name(),
                'tipo_centro_universitario' => $faker->randomElement($tipos),
                'centro_universitario'      => $nombre,
                'siglas'                    => $siglas,
                'direccion'                 => $faker->streetAddress . ', ' . $faker->city,
                'telefonos'                 => '33 ' . $faker->numberBetween(3000, 3999) . ' ' . $faker->numberBetween(3000, 3999),
                'sitio_web'                 => 'https://www.' . $slug . '.udg.mx',
                'colonia'                   => $faker->optional()->streetName(),
                'codigo_postal'             => (string) $faker->numberBetween(44000, 49999),
                'municipio'                 => $faker->city(),
                'estado'                    => 'Jalisco',
                'pais'                      => 'México',
                'vigente'                   => 1,
            ];

            // Normaliza vacíos a NULL si tu esquema lo permite
            if ($data['colonia'] === '') $data['colonia'] = null;

            // Upsert por siglas
            CentroUniversitario::updateOrCreate(
                ['siglas' => $siglas],
                $data
            );
        }
    }
}
