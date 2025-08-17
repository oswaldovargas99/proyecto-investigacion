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
        ]);
    }
}



