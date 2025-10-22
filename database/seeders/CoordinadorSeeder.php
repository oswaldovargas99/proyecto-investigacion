<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CoordinadorSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'codigo' => 'COD001',
                'nombre' => 'María López Hernández',
                'user_email' => 'maria.lopez@udg.mx',
                'centro_id' => 1, 'posgrado_id' => 1,
                'nivel' => 'Maestría', 'genero' => 'Femenino',
                'fecha_nacimiento' => '1980-05-12',
                'correo_alternativo' => 'maria.lopez@gmail.com',
                'telefono' => '3334567890', 'extension' => '123', 'celular' => '3312345678',
            ],
            [
                'codigo' => 'COD002',
                'nombre' => 'Juan Pérez Ramírez',
                'user_email' => 'juan.perez@udg.mx',
                'centro_id' => 2, 'posgrado_id' => 2,
                'nivel' => 'Doctorado', 'genero' => 'Masculino',
                'fecha_nacimiento' => '1975-11-03',
                'correo_alternativo' => 'juan.perez@hotmail.com',
                'telefono' => '3335678901', 'extension' => '124', 'celular' => '3323456789',
            ],
            [
                'codigo' => 'COD003',
                'nombre' => 'Laura Martínez Torres',
                'user_email' => 'laura.martinez@udg.mx',
                'centro_id' => 3, 'posgrado_id' => 3,
                'nivel' => 'Especialidad', 'genero' => 'Femenino',
                'fecha_nacimiento' => '1985-07-25',
                'correo_alternativo' => 'laura.mtz@gmail.com',
                'telefono' => '3336789012', 'extension' => '125', 'celular' => '3334567891',
            ],
            [
                'codigo' => 'COD004',
                'nombre' => 'Carlos Ramírez Gómez',
                'user_email' => 'carlos.ramirez@udg.mx',
                'centro_id' => 1, 'posgrado_id' => 4,
                'nivel' => 'Maestría', 'genero' => 'Masculino',
                'fecha_nacimiento' => '1982-09-15',
                'correo_alternativo' => 'carlos.rgz@yahoo.com',
                'telefono' => '3337890123', 'extension' => '126', 'celular' => '3335678902',
            ],
            [
                'codigo' => 'COD005',
                'nombre' => 'Ana Torres Díaz',
                'user_email' => 'ana.torres@udg.mx',
                'centro_id' => 2, 'posgrado_id' => 5,
                'nivel' => 'Doctorado', 'genero' => 'No Binario',
                'fecha_nacimiento' => '1990-02-28',
                'correo_alternativo' => 'ana.td@gmail.com',
                'telefono' => '3338901234', 'extension' => '127', 'celular' => '3336789013',
            ],
        ];

        foreach ($rows as $r) {
            // Asegurar usuario y obtener su ID
            $userId = DB::table('users')->where('email', $r['user_email'])->value('id');
            if (!$userId) {
                $userId = DB::table('users')->insertGetId([
                    'name' => $r['nombre'],
                    'email' => $r['user_email'],
                    'password' => Hash::make('password123'), // cámbialo si gustas
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }

            // Resolver IDs de catálogos por nombre
            $nivelId  = DB::table('pfp_niveles_estudios')->where('nivel_estudios', $r['nivel'])->value('id');
            $generoId = DB::table('pfp_generos')->where('genero', $r['genero'])->value('id');

            // Fallbacks seguros por si algo no está (evita nulls en FKs)
            $centroId   = $r['centro_id'] ?? DB::table('pfp_centros_universitarios')->min('id');
            $posgradoId = $r['posgrado_id'] ?? DB::table('pfp_posgrados')->min('id');
            if (!$nivelId)  { $nivelId  = DB::table('pfp_niveles_estudios')->min('id'); }
            if (!$generoId) { $generoId = DB::table('pfp_generos')->min('id'); }

            // Insertar/actualizar por 'codigo' (único)
            DB::table('pfp_coordinadores')->updateOrInsert(
                ['codigo' => $r['codigo']],
                [
                    'nombre_coordinador'      => $r['nombre'],
                    'user_id'                 => $userId,
                    'centro_universitario_id' => $centroId,
                    'posgrado_id'             => $posgradoId,
                    'nivel_estudios_id'       => $nivelId,
                    'genero_id'               => $generoId,
                    'fecha_nacimiento'        => $r['fecha_nacimiento'],
                    'correo_institucional'    => $r['user_email'],
                    'correo_alternativo'         => $r['correo_alternativo'],
                    'telefono'                => $r['telefono'],
                    'extension'               => $r['extension'],
                    'celular'          => $r['celular'],
                    'created_at'              => now(),
                    'updated_at'              => now(),
                ]
            );
        }
    }
}
