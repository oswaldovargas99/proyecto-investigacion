<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Aquí puedes llamar todos los seeders que quieras ejecutar
        $this->call([
            UserSeeder::class,
            //CentroUniversitarioSeeder::class,
            NivelesAcademicosSeeder::class,
            OrientacionesSeeder::class,
            ModalidadesSeeder::class,
            //PosgradoSeeder::class,
            NivelesEstudiosSeeder::class,
            GenerosSeeder::class,
            //CoordinadorSeeder::class,
            CategoriasMejorasSeeder::class,
            CriteriosSnpSeeder::class,
            TiposBeneficiariosSeeder::class,
            TemasSeeder::class,
            RubroCategoriasSeeder::class,
            RubrosSeeder::class,

        ]);
    }
}



