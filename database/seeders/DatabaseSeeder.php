<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear Roles
        $this->call(RolesSeeder::class);

        // 2. Obtener IDs de roles para asignar
        $adminRole = Role::where('name', 'admin')->first();
        $supervisorRole = Role::where('name', 'supervisor')->first();
        $mantenimientoRole = Role::where('name', 'mantenimiento')->first();
        $userRole = Role::where('name', 'user')->first();

        // 3. Crear Usuario Admin
        User::factory()->create([
            'name' => 'Admin General',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'status' => true,
        ]);

        // 4. Crear Usuario Mantenimiento
        User::factory()->create([
            'name' => 'Técnico Mantenimiento',
            'email' => 'mant@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $mantenimientoRole->id,
            'status' => true,
        ]);

        // 5. Crear Supervisor
        $supervisor = User::factory()->create([
            'name' => 'Supervisor Zona 1',
            'email' => 'sup@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $supervisorRole->id,
            'status' => true,
        ]);

        // 6. Crear Usuarios subordinados al Supervisor
        User::factory()->count(3)->create([
            'role_id' => $userRole->id,
            'supervisor_id' => $supervisor->id, // Asignar al supervisor creado
            'status' => true,
        ]);

        // 7. Crear Usuario sin supervisor
        User::factory()->create([
            'name' => 'Usuario Independiente',
            'email' => 'user@admin.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'status' => true,
        ]);
    }
}
