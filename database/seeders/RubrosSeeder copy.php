<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubrosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1) Semillas de categorías (tabla: pfp_rubros_categorias)
        $categorias = [
            ['categoria' => '2000 - MATERIALES Y SUMINISTROS',                  'descripcion' => null, 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3000 - SERVICIOS GENERALES',                       'descripcion' => null, 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES',  'descripcion' => null, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('pfp_rubros_categorias')->upsert(
            $categorias,
            ['categoria'],                 // uniqueBy
            ['descripcion', 'updated_at']  // columns to update
        );

        // Mapa categoria => id
        $catIds = DB::table('pfp_rubros_categorias')->pluck('id', 'categoria')->toArray();

        // Helpers
        $cat = fn (string $label) => $catIds[$label] ?? null;

        // 2) Semillas de rubros (tabla: pfp_rubros)
        $rubros = [
            // ===== 2000 - MATERIALES Y SUMINISTROS =====
            ['rubro' => '2111', 'concepto' => 'Materiales, útiles y equipos menores de oficina',        'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2112', 'concepto' => 'Papelería y artículos de oficina',                        'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2113', 'concepto' => 'Tóner y consumibles para impresión',                      'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2121', 'concepto' => 'Productos alimenticios para eventos de trabajo',          'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2131', 'concepto' => 'Productos de limpieza e higiene',                         'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2141', 'concepto' => 'Combustibles, lubricantes y aditivos',                    'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2151', 'concepto' => 'Herramientas menores y refacciones',                      'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2161', 'concepto' => 'Materiales eléctricos y electrónicos',                    'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2171', 'concepto' => 'Material didáctico y educativo',                          'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '2181', 'concepto' => 'Equipo y accesorios menores de cómputo',                  'categoria_id' => $cat('2000 - MATERIALES Y SUMINISTROS'), 'created_at'=>$now, 'updated_at'=>$now],

            // ===== 3000 - SERVICIOS GENERALES =====
            ['rubro' => '3111', 'concepto' => 'Servicios básicos (agua, energía, telefonía e internet)', 'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3120', 'concepto' => 'Servicios de impresión y reproducción',                   'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3130', 'concepto' => 'Mantenimiento y reparación de equipo',                    'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3140', 'concepto' => 'Arrendamientos',                                          'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3150', 'concepto' => 'Servicios de consultoría, estudios e investigaciones',    'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3160', 'concepto' => 'Viáticos y pasajes nacionales',                           'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3161', 'concepto' => 'Viáticos y pasajes internacionales',                      'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3170', 'concepto' => 'Servicios de difusión y publicidad',                      'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '3180', 'concepto' => 'Servicios de capacitación y eventos',                     'categoria_id' => $cat('3000 - SERVICIOS GENERALES'),      'created_at'=>$now, 'updated_at'=>$now],

            // ===== 5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES =====
            ['rubro' => '5111', 'concepto' => 'Equipo de cómputo y tecnología (adquisición)',            'categoria_id' => $cat('5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '5121', 'concepto' => 'Mobiliario y equipo de oficina (adquisición)',            'categoria_id' => $cat('5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES'), 'created_at'=>$now, 'updated_at'=>$now],
            ['rubro' => '5131', 'concepto' => 'Software y licencias (adquisición)',                      'categoria_id' => $cat('5000 - BIENES MUEBLES, INMUEBLES E INTANGIBLES'), 'created_at'=>$now, 'updated_at'=>$now],
        ];

        DB::table('pfp_rubros')->upsert(
            $rubros,
            ['rubro'], // uniqueBy
            ['concepto', 'categoria_id', 'updated_at'] // columns to update
        );
    }
}
