<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Verificar Login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 2. Cargar relación Role si falta
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        // 3. Validación de seguridad: ¿El usuario tiene rol asignado?
        if (!$user->role) {
            Auth::logout();
            return abort(403, 'Error crítico: El usuario no tiene un rol asignado en la base de datos.');
        }

        // 4. Normalizar datos (Minúsculas y sin espacios extra)
        // Ejemplo: " Admin " -> "admin"
        $userRoleName = strtolower(trim($user->role->name));

        foreach ($roles as $role) {
            if ($userRoleName === strtolower(trim($role))) {
                return $next($request);
            }
        }

        // 5. Si falló la validación, mostramos QUÉ falló para depurar
        // Esto te dirá en pantalla: "Tu rol es: admin. Se requiere: supervisor"
        $requiredRoles = implode(', ', $roles);

        return abort(403, "Acceso denegado. Tu rol actual es: '{$userRoleName}'. Esta sección requiere uno de estos roles: '{$requiredRoles}'.");
    }
}
