<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RubrosSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Rubros agrupados por categoría
        $rubrosPorCategoria = [

            '2000' => [
                ['2111', 'Materiales, útiles y equipos menores de oficina'],
                ['2121', 'Materiales y útiles de impresión y reproducción'],
                ['2131', 'Material estadístico y geográfico'],
                ['2141', 'Materiales, útiles y equipos menores de tecnologías de la información y comunicaciones'],
                ['2151', 'Material impreso'],
                ['2152', 'Material audiovisual'],
                ['2153', 'Libros, revistas, periódicos y otros'],
                ['2154', 'Revistas, periódicos, suscripciones y otros'],
                ['2161', 'Artículos de limpieza'],
                ['2171', 'Materiales y útiles de enseñanza'],
            ],

            '2200' => [
                ['2211', 'Productos alimenticios para personas en las instalaciones de la Red Universitaria'],
                ['2212', 'Productos alimenticios para personas que realizaron labores de campo o supervisión'],
                ['2221', 'Productos alimenticios para animales'],
                ['2231', 'Utensilios para el servicio de alimentación'],
            ],

            '2300' => [
                ['2311', 'Productos alimenticios, agropecuarios y forestales adquiridos como materia prima'],
            ],

            '2400' => [
                ['2411', 'Productos minerales no metálicos'],
                ['2461', 'Material eléctrico y electrónico'],
                ['2481', 'Materiales complementarios'],
                ['2491', 'Otros materiales y artículos de construcción y reparación'],
            ],

            '2500' => [
                ['2511', 'Productos químicos básicos'],
                ['2521', 'Fertilizantes, pesticidas y otros agroquímicos'],
                ['2531', 'Medicinas y productos farmacéuticos'],
                ['2541', 'Materiales, accesorios y suministros médicos'],
                ['2551', 'Accesorios y suministros de laboratorio'],
                ['2561', 'Fibras sintéticas, hules, plásticos y derivados'],
                ['2591', 'Otros productos químicos'],
            ],

            '2600' => [
                ['2611', 'Combustibles para vehículos'],
                ['2612', 'Aceites, lubricantes y aditivos'],
                ['2613', 'Combustibles para aparatos, equipos y maquinaria en general'],
            ],

            '2900' => [
                ['2911', 'Herramientas menores'],
                ['2921', 'Refacciones y accesorios menores de edificios'],
                ['2931', 'Refacciones y accesorios menores de mobiliario y equipo de administración, educacional y recreativo'],
                ['2941', 'Refacciones y accesorios para equipo de cómputo y tecnologías de la información'],
                ['2951', 'Refacciones y accesorios menores de equipo e instrumental médico de laboratorio'],
                ['2961', 'Refacciones y accesorios menores de equipo de transporte'],
                ['2981', 'Refacciones y accesorios menores de maquinaria y otros equipos'],
                ['2991', 'Mobiliario de oficina y estantería'],
                ['2993', 'Otros mobiliarios y equipos de administración'],
                ['2994', 'Sistemas de aire acondicionado, calefacción y de refrigeración industrial y comercial'],
                ['2995', 'Maquinaria y equipo agropecuario'],
                ['2996', 'Maquinaria y equipo industrial'],
                ['2998', 'Equipo de comunicación y telecomunicaciones'],
                ['2999', 'Equipos de generación eléctrica, aparatos y accesorios eléctricos'],
                ['29910', 'Herramientas y máquinas - refacciones y accesorios'],
                ['29911', 'Equipo informático'],
                ['29912', 'Otros bienes inventariables no capitalizables'],
            ],

            '3000' => [
                ['3171', 'Servicios de acceso de internet, redes y procesamiento de información'],
                ['3181', 'Servicios postales y telegráficos'],
                ['3191', 'Servicios integrales y otros servicios'],
            ],

            '3300' => [
                ['3311', 'Servicios legales, de contabilidad, auditoría y relacionados con personas físicas'],
                ['3312', 'Servicios legales, de contabilidad, auditoría y relacionados con personas morales'],
                ['3321', 'Servicios de diseño, arquitectura, ingeniería y actividades relacionadas con personas físicas'],
                ['3322', 'Servicios de diseño, arquitectura, ingeniería y actividades relacionadas con personas morales'],
                ['3331', 'Servicios de consultoría administrativa, procesos, técnica y en tecnologías de la información con personas físicas'],
                ['3332', 'Servicios de consultoría administrativa, procesos, técnica y en tecnologías de la información con personas morales'],
                ['3341', 'Servicios de capacitación con personas físicas'],
                ['3342', 'Servicios de capacitación con personas morales'],
                ['3351', 'Servicios de investigación científica y desarrollo con personas físicas'],
                ['3352', 'Servicios de investigación científica y desarrollo con personas morales'],
                ['3361', 'Servicios de apoyo administrativo, fotocopiado e impresión con personas físicas'],
                ['3362', 'Servicios de apoyo administrativo, fotocopiado e impresión con personas morales'],
                ['3391', 'Servicios profesionales, científicos y técnicos integrales con personas físicas'],
                ['3392', 'Servicios profesionales, científicos y técnicos integrales con personas morales'],
            ],

            '3500' => [
                ['3511', 'Conservación y mantenimiento menor de inmuebles'],
                ['3521', 'Instalación, reparación y mantenimiento de mobiliario y equipo de administración, educacional y recreativo'],
                ['3531', 'Instalación, reparación y mantenimiento de equipo de cómputo y tecnologías de la información'],
                ['3541', 'Instalación, reparación y mantenimiento de equipo e instrumental médico y de laboratorio'],
                ['3571', 'Mantenimiento y conservación de maquinaria y equipo'],
                ['3572', 'Servicios de instalación'],
                ['3581', 'Servicios de limpieza y manejo de desechos'],
            ],

            '3600' => [
                ['3611', 'Gastos de propaganda e imagen institucional'],
                ['3612', 'Impresiones y publicaciones'],
                ['3621', 'Difusión por radio, televisión y otros medios de mensaje comerciales'],
                ['3631', 'Servicios de creatividad, preproducción y producción de publicidad'],
                ['3691', 'Otros servicios de información'],
            ],

            '3700' => [
                ['3711', 'Pasajes aéreos nacionales e internacionales'],
                ['3721', 'Pasajes terrestres nacionales'],
                ['3722', 'Pasajes terrestres nacionales para la gestión entre dependencias'],
                ['3751', 'Viáticos hospedaje nacional'],
                ['3752', 'Viáticos hospedaje para la gestión entre dependencias'],
                ['3753', 'Viáticos alimentación'],
                ['3754', 'Viáticos alimentación para la gestión entre dependencias'],
                ['3755', 'Viáticos otros gastos en el país'],
                ['3761', 'Viáticos hospedaje en el extranjero'],
                ['3762', 'Viáticos alimentación en el extranjero'],
                ['3763', 'Viáticos otros gastos en el extranjero'],
            ],

            '3800' => [
                ['3831', 'Congresos y convenciones'],
                ['3841', 'Exposiciones'],
                ['3851', 'Gastos de consumo en restaurante por representación oficial'],
            ],

            '4000' => [
                ['4411', 'Becarios'],
            ],

            '4420' => [
                ['4421', 'Becas alumnos nacionales'],
                ['4422', 'Becas alumnos extranjeros'],
            ],

            '5000' => [
                ['5111', 'Muebles de oficina y estantería'],
                ['5121', 'Muebles, excepto de oficina y estantería'],
                ['5131', 'Libros, textos y colecciones'],
                ['5151', 'Equipo de cómputo y de tecnologías de la información'],
                ['5191', 'Otros mobiliarios y equipos de administración'],
            ],

            '5200' => [
                ['5211', 'Equipos y aparatos audiovisuales'],
                ['5221', 'Aparatos deportivos'],
                ['5231', 'Cámaras fotográficas y de video'],
                ['5291', 'Instrumentos y equipos musicales'],
                ['5292', 'Instrumentos y equipos educacionales y recreativos'],
            ],

            '5300' => [
                ['5311', 'Equipo médico y de laboratorio'],
                ['5321', 'Instrumental médico y de laboratorio'],
            ],

            '5600' => [
                ['5611', 'Maquinaria y equipo agropecuario'],
                ['5621', 'Maquinaria y equipo industrial'],
                ['5641', 'Sistemas de aire acondicionado, calefacción y de refrigeración industrial y comercial'],
                ['5651', 'Equipo de comunicación y telecomunicación'],
                ['5661', 'Equipo de generación eléctrica, aparatos y accesorios eléctricos'],
                ['5671', 'Herramientas y máquinas-herramientas'],
                ['5691', 'Otros equipos'],
            ],

            '5900' => [
                ['5911', 'Software'],
                ['5971', 'Licencias informáticas e intelectuales'],
                ['5991', 'Otros activos intangibles'],
            ],
        ];

        // Obtener IDs reales de las categorías desde la BD
        $categorias = DB::table('pfp_rubros_categorias')
            ->pluck('id', 'categoria'); // ['2000' => 1, ...]

        $rows = [];
        foreach ($rubrosPorCategoria as $codigoCategoria => $rubros) {
            $categoriaId = $categorias[$codigoCategoria] ?? null;
            if (!$categoriaId) continue;

            foreach ($rubros as [$rubro, $concepto]) {
                $rows[] = [
                    'rubro'        => (string) $rubro,
                    'concepto'     => $concepto,
                    'categoria_id' => $categoriaId,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }

        // upsert con base en 'rubro'
        DB::table('pfp_rubros')->upsert(
            $rows,
            ['rubro'],
            ['concepto', 'categoria_id', 'updated_at']
        );
    }
}
