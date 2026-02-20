<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@inventario.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '1234567890',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Usuario gerente
        User::create([
            'name' => 'Gerente',
            'email' => 'gerente@inventario.com',
            'password' => Hash::make('gerente123'),
            'role' => 'manager',
            'phone' => '0987654321',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Usuario empleado
        User::create([
            'name' => 'Empleado',
            'email' => 'empleado@inventario.com',
            'password' => Hash::make('empleado123'),
            'role' => 'employee',
            'phone' => '11111111',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Crear 10 usuarios adicionales
        User::factory()->count(10)->create();
    }
}
