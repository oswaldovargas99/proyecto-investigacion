<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CriteriosSnpSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Mapa de categorías por acrónimo detectado al final del nombre, p. ej. "(CI)"
        $categorias = DB::table('pfp_categorias_mejoras')->pluck('id','categoria')->toArray();
        $map = [];
        foreach ($categorias as $nombre => $id) {
            if (preg_match('/\(([^)]+)\)\s*$/', $nombre, $m)) {
                $map[$m[1]] = $id; // 'CI' => id, 'EPA' => id, etc.
            }
        }

        // Definición de criterios por categoría (usa la columna 'nombre')
        $def = [
            'CI' => [
                '(CI) Compromiso Institucional',
                '(CI) Sistema de Aseguramiento de la Calidad',
            ],
            'EPA' => [
                '(EPA) Plan de Estudios',
                '(EPA) Núcleo Académico',
                '(EPA) Estudiantes y Egreso',
                '(EPA) Infraestructura',
                '(EPA) Internacionalización del Currículo',
            ],
            'DT' => [
                '(DT) Desarrollo de Habilidades',
                '(DT) Tutorías y Acompañamiento',
                '(DT) Formación Complementaria',
            ],
            'PE' => [
                '(PE) Producción Académica',
                '(PE) Impacto Social y Académico',
                '(PE) Difusión y Transferencia',
            ],
            'RV' => [
                '(RV) Contribución al Conocimiento',
                '(RV) Vinculación',
                '(RV) Financiamiento',
            ],
        ];

        // Asegura que existan las categorías; si falta alguna, la crea
        foreach ($def as $cod => $items) {
            if (!isset($map[$cod])) {
                $catName = match($cod) {
                    'CI' => 'Compromiso Institucional (CI)',
                    'EPA' => 'Estructura del Programa Académico (EPA)',
                    'DT' => 'Desarrollo del Talento (DT)',
                    'PE' => 'Producción y Efectos (PE)',
                    'RV' => 'Resultados y Vinculación (RV)',
                    default => $cod
                };
                $map[$cod] = DB::table('pfp_categorias_mejoras')->insertGetId([
                    'categoria'  => $catName,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            foreach ($items as $nombre) {
                DB::table('pfp_criterios_snp')->updateOrInsert(
                    ['nombre' => $nombre, 'categoria_mejora_id' => $map[$cod]],
                    ['created_at' => $now, 'updated_at' => $now]
                );
            }
        }

        // Criterio genérico "Otro" (se asigna a la primera categoría disponible)
        if (!empty($map)) {
            $fallbackId = reset($map);
            DB::table('pfp_criterios_snp')->updateOrInsert(
                ['nombre' => 'Otro', 'categoria_mejora_id' => $fallbackId],
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
