<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Definir Permisos Granulares
        $permissions = [
            'view_live',        // Ver transmisión en vivo
            'view_recordings',  // Ver grabaciones
            'manage_cameras',   // Crear, Editar, Eliminar cámaras
            'assign_cameras',   // Asignar cámaras a otros usuarios (Admin)
            'manage_users',     // Crear/Editar usuarios
            'view_audit_logs',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 2. Definir Roles y sus Permisos
        $roles = [
            'superadmin' => $permissions, // Acceso total

            'admin' => [
                'view_live',
                'view_recordings',
                'manage_cameras',
                'assign_cameras', // Admin puede asignar cámaras a usuarios
                'manage_users'
            ],

            'supervisor' => [
                'view_live',
                'view_recordings'
                // El supervisor NO edita cámaras, solo ve las de su grupo
            ],

            'mantenimiento' => [
                'manage_cameras'
                // Puede crear/editar cámaras, pero NO tiene 'view_live' ni 'view_recordings'
            ],

            'user' => [
                'view_live',
                'view_recordings'
                // Solo ve las suyas (validado en Controller)
            ],
        ];

        foreach ($roles as $role => $perms) {
            $r = Role::firstOrCreate(['name' => $role]);
            $r->syncPermissions($perms);
        }
    }
}

