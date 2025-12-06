@extends('components.layouts.app')

@section('titulo', 'Panel General')

@section('contenido')

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Bienvenido, {{ Auth::user()->name }}</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Resumen de actividad y estado del sistema.</p>
        </div>
        <span class="px-4 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full text-xs font-bold border border-blue-100 dark:border-blue-800">
            {{ now()->format('d M, Y') }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wider">Cámaras Activas</h3>
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ \App\Models\Camera::where('status', true)->count() }}
                <span class="text-sm font-normal text-slate-400 dark:text-slate-500 ml-1">/ {{ \App\Models\Camera::count() }}</span>
            </p>
        </div>

<div class="p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wider">Personal</h3>
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ \App\Models\User::where('role_id', '!=', 1)->count() }}
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-slate-500 dark:text-slate-400 text-sm font-medium uppercase tracking-wider">Incidencias</h3>
                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg text-amber-600 dark:text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-900 dark:text-white">0</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('admin.cameras.index') }}" class="group p-6 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-2xl text-white shadow-lg hover:shadow-indigo-500/30 transition-all hover:-translate-y-1">
            <h3 class="text-xl font-bold mb-1">Gestión de Cámaras</h3>
            <p class="text-indigo-100 text-sm mb-4">Ver transmisiones y configurar dispositivos.</p>
            <span class="inline-flex items-center gap-2 text-sm font-semibold group-hover:gap-3 transition-all">
                Ir ahora <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
        </a>

        <a href="{{ route('admin.personal.index') }}" class="group p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl hover:border-indigo-500 dark:hover:border-indigo-500 transition-all">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Personal</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-4">Administrar accesos y usuarios.</p>
            <span class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 group-hover:gap-3 transition-all">
                Gestionar <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </span>
        </a>
    </div>

@endsection