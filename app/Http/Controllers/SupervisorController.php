<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Camera; // Importamos el modelo Cámara

class SupervisorController extends Controller
{
    public function dashboard()
    {
        // 1. Calcular Estadísticas en Tiempo Real
        $totalCameras   = Camera::count();
        $activeCameras  = Camera::where('status', true)->count();
        $offlineCameras = Camera::where('status', false)->count();
        
        // Calcular porcentaje de operatividad (para una barra de progreso visual)
        $healthPercent  = $totalCameras > 0 ? round(($activeCameras / $totalCameras) * 100) : 0;

        // 2. Obtener las 5 cámaras más recientes (Novedades)
        $recentCameras  = Camera::latest()->take(5)->get();

        // 3. Enviar todo a la vista
        return view('supervisor.dashboard', compact(
            'totalCameras', 
            'activeCameras', 
            'offlineCameras', 
            'healthPercent',
            'recentCameras'
        ));
    }
}