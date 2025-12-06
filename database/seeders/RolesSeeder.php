<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Usamos firstOrCreate para no duplicar si ya existen
        Role::firstOrCreate(['name' => 'admin'], ['description' => 'Administrador Total']);
        Role::firstOrCreate(['name' => 'supervisor'], ['description' => 'Supervisor de Operaciones']);
        Role::firstOrCreate(['name' => 'mantenimiento'], ['description' => 'Técnico de Cámaras']);
        Role::firstOrCreate(['name' => 'user'], ['description' => 'Guardia / Visualizador']);
    }
}