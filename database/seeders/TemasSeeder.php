<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pfp_temas')->insert([
            ['nombre' => 'Publicaciones y presentación de ponencias en congresos en coautoría profesores y alumnos del posgrado correspondiente.'],
            ['nombre' => 'Incorporación de alumnos en proyectos de investigación liderados por profesores del posgrado correspondiente.'],
            ['nombre' => 'Acciones para contar con suficientes solicitudes de ingreso que permita alcanzar la matrícula necesaria para la apertura del programa de posgrado.'],
            ['nombre' => 'Desarrollo de actividades de retribución social.'],
            ['nombre' => 'Incremento de la eficiencia terminal.'],
            ['nombre' => 'Vinculación con otras instituciones de educación y de otros sectores (social, económico, ambiental, gubernamental, salud, etcétera).'],
            ['nombre' => 'Movilidad de profesores y alumnos, así como acciones de internacionalización del currículo con instituciones nacionales e internacionales.'],
            ['nombre' => 'Desarrollo capacidades tecnológicas, operativas y/o de formación para la implementación de modelos híbridos de enseñanza.'],
            ['nombre' => 'Mejora del diseño curricular poniendo énfasis en la justificación y pertinencia científica y social del programa.'],
            ['nombre' => 'Seguimiento de egresados basados en la interacción continua y la formación de redes de cooperación y acción.'],
        ]);
    }
}

