<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario Administrador (rol 3)
        User::updateOrCreate(
            ['email' => 'admin@udg.mx'], // criterio único
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'role' => 3,
            ]
        );

        // Usuario Coordinador (rol 2)
        User::updateOrCreate(
            ['email' => 'coordinador@udg.mx'],
            [
                'name' => 'Coordinador',
                'password' => Hash::make('coord123'),
                'role' => 2,
            ]
        );
    }
}

