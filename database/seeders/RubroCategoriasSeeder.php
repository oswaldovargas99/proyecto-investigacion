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
            ['categoria' => '2200', 'descripcion' => 'Alimentos y Utensilios', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '2300', 'descripcion' => 'Materias Primas y Materiales De Producción y Comercialización', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '2400', 'descripcion' => 'Materiales y Artículos de Construcción y de Reparación', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '2500', 'descripcion' => 'Productos Químicos, Farmacéuticos y de Laboratorio', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '2600', 'descripcion' => 'Combustibles, Lubricantes y Aditivos', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '2900', 'descripcion' => 'Herramientas, Refacciones y Accesorios Menores', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3000', 'descripcion' => 'Servicios Generales', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3300', 'descripcion' => 'Servicios Profesionales, Científicos, Técnicos y Otros Servicios', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3500', 'descripcion' => 'Servicios de Instalación, Reparación, Mantenimiento y Conservación', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3600', 'descripcion' => 'Servicios de Comunicación Social y Publicidad', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3700', 'descripcion' => 'Servicios de Traslado y Viáticos', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '3800', 'descripcion' => 'Servicios Oficiales', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '4000', 'descripcion' => 'Transferencias, Asignaciones, Subsidios y Otras Ayudas', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '4420', 'descripcion' => 'Becas y Otras Ayudas para Programas de Capacitación', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '5000', 'descripcion' => 'Bienes Muebles, Inmuebles e Intangibles', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '5200', 'descripcion' => 'Mobiliario y Equipo Educacional y Recreativo', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '5300', 'descripcion' => 'Equipo e Instrumental Médico y de Laboratorio', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '5600', 'descripcion' => 'Maquinaria, Otros Equipos y Herramientas', 'created_at' => $now, 'updated_at' => $now],
            ['categoria' => '5900', 'descripcion' => 'Activos Intangibles', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('pfp_rubros_categorias')->upsert(
            $rows,
            ['categoria'], // campo único
            ['descripcion', 'updated_at']
        );
    }
}
