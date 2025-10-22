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
        User::firstOrCreate(
            ['email' => 'admin@udg.mx'], // criterio único
            [
                'name'       => 'Administrador',
                'password'   => Hash::make('admin123'),
                'role'       => 3,
                'is_active'  => true,
            ]
        );

        // Usuario Coordinador (rol 2)
        User::firstOrCreate(
            ['email' => 'coordinador@udg.mx'],
            [
                'name'       => 'Coordinador',
                'password'   => Hash::make('coord123'),
                'role'       => 2,
                'is_active'  => true,
            ]
        );

        // Usuario (rol 1)
        User::firstOrCreate(
            ['email' => 'usuario@udg.mx'],
            [
                'name'       => 'Usuario',
                'password'   => Hash::make('usuario123'),
                'role'       => 1,
                'is_active'  => true,
            ]
        );
    }
}
