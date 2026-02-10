<?php

namespace Database\Seeders;
use App\Models\User; // El modelo User se importa en el seeder para poder utilizarlo
use Illuminate\Support\Facades\Hash; //Se importa la clase Hash para poder hashear la contraseña del usuario admin
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@miura.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make(value: 'password123'), //TODO: agregar una contraseña más segura y referenciarlo desde los ENV.
                'is_admin' => true,
            ]
        );
    }
}
