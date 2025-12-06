<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // --- 1. PERMISOS DE VISUALIZACIÓN (El más importante para el video) ---
        
        // Todos los usuarios autenticados pueden ver cámaras y video
        Gate::define('ver_camaras', function (User $user) {
            return true; 
        });

        // --- 2. PERMISOS DE GESTIÓN ---

        // Crear: Solo Admin y Supervisor
        Gate::define('crear_camaras', function (User $user) {
            return in_array($user->role->name, ['admin', 'supervisor']);
        });

        // Editar: Admin, Supervisor y Mantenimiento
        Gate::define('editar_camaras', function (User $user) {
            return in_array($user->role->name, ['admin', 'supervisor', 'mantenimiento']);
        });

        // Borrar: SOLO Admin
        Gate::define('borrar_camaras', function (User $user) {
            return $user->role->name === 'admin';
        });

        // --- 3. PERMISOS DE PERSONAL ---

        Gate::define('gestionar_personal', function (User $user) {
            return $user->role->name === 'admin';
        });

        // --- 4. PERMISOS DE DASHBOARDS ---

        Gate::define('ver_dashboard_global', function (User $user) {
            return in_array($user->role->name, ['admin', 'supervisor']);
        });

        Gate::define('ver_dashboard_tecnico', function (User $user) {
            return $user->role->name === 'mantenimiento';
        });
    }
}