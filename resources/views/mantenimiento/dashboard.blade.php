@extends('components.layouts.app')

@section('titulo', 'Panel Técnico')

@section('contenido')

    <div class="flex flex-col sm:flex-row justify-between items-end mb-8 gap-4 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                Panel de Mantenimiento 🛠️
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg">
                Estado de la red y diagnósticos.
            </p>
        </div>
        <div class="text-right hidden sm:block">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold border border-amber-200 dark:border-amber-800">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                </span>
                Modo Técnico Activo
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Inventario Total</h3>
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-slate-900 dark:text-white">
                {{ $totalCameras }}
                <span class="text-sm font-medium text-slate-400 ml-1">disp.</span>
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl border-l-4 border-red-500 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-red-600 dark:text-red-400 text-xs font-bold uppercase tracking-wider">Requieren Atención</h3>
                <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg text-red-600 dark:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-slate-900 dark:text-white">
                {{ $offlineCameras }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Cámaras sin señal o apagadas.</p>
        </div>

        <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Operativas</h3>
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="text-4xl font-bold text-slate-900 dark:text-white">
                {{ $totalCameras - $offlineCameras }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Funcionando correctamente.</p>
        </div>
    </div>

    <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-3xl p-8 shadow-xl text-white relative overflow-hidden group">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold mb-2">Gestión de Dispositivos</h2>
                <p class="text-slate-300 max-w-xl">
                    Accede al listado completo para editar configuraciones IP, nombres o verificar la transmisión de video en tiempo real.
                </p>
            </div>
            <a href="{{ route('mantenimiento.cameras.index') }}" class="whitespace-nowrap px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1">
                Ver Inventario &rarr;
            </a>
        </div>
        
        <svg class="absolute right-0 top-0 h-64 w-64 text-slate-700/20 transform translate-x-1/4 -translate-y-1/4 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
    </div>

@endsection