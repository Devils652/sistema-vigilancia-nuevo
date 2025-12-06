@extends('components.layouts.app')

@section('titulo', 'Centro de Operaciones')

@section('contenido')

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4 animate-fade-in-down">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                Hola, Supervisor {{ Auth::user()->name }} 
                <span class="text-2xl">👋</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg">
                Resumen operativo del sistema de videovigilancia.
            </p>
        </div>
        <div class="bg-white dark:bg-slate-800 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm text-sm font-semibold text-slate-600 dark:text-slate-300">
            📅 {{ now()->isoFormat('D [de] MMMM, YYYY') }}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 group hover:border-blue-400 dark:hover:border-blue-500 transition-colors">
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full blur-xl group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-all"></div>
            <div class="relative z-10">
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Inventario Total</p>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-4xl font-bold text-slate-900 dark:text-white">{{ $totalCameras }}</span>
                    <span class="text-sm font-medium text-slate-400">cámaras</span>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('supervisor.cameras.index') }}" class="text-blue-600 dark:text-blue-400 text-sm font-bold hover:underline inline-flex items-center gap-1">
                    Ver inventario <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Operatividad</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="text-4xl font-bold text-emerald-600 dark:text-emerald-400">{{ $activeCameras }}</span>
                        <span class="text-sm font-medium text-slate-400">activas</span>
                    </div>
                </div>
                <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2.5 mt-2">
                <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-1000" style="width: {{ $healthPercent }}%"></div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 text-right">{{ $healthPercent }}% del sistema online</p>
        </div>

        <div class="relative overflow-hidden bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-l-4 border-slate-200 dark:border-slate-700 {{ $offlineCameras > 0 ? 'border-l-red-500' : 'border-l-green-500' }}">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Fuera de Línea</p>
                    <div class="flex items-baseline gap-2 mt-2">
                        <span class="text-4xl font-bold {{ $offlineCameras > 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-700 dark:text-slate-300' }}">{{ $offlineCameras }}</span>
                        <span class="text-sm font-medium text-slate-400">inactivas</span>
                    </div>
                </div>
                @if($offlineCameras > 0)
                    <span class="relative flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                @endif
            </div>
            @if($offlineCameras > 0)
                <p class="text-xs text-red-600 dark:text-red-400 mt-4 font-semibold bg-red-50 dark:bg-red-900/20 py-1 px-2 rounded inline-block">
                    ⚠️ Requiere mantenimiento
                </p>
            @else
                <p class="text-xs text-green-600 dark:text-green-400 mt-4 font-semibold bg-green-50 dark:bg-green-900/20 py-1 px-2 rounded inline-block">
                    ✅ Sistema óptimo
                </p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="space-y-6">
            <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-xl shadow-indigo-500/20 relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold">Expandir Red</h3>
                    <p class="text-indigo-100 text-sm mb-6 opacity-90">Agregar una nueva cámara al sistema de monitoreo.</p>
                    <a href="{{ route('supervisor.cameras.create') }}" class="inline-flex items-center justify-center w-full bg-white text-indigo-600 font-bold py-3 rounded-xl hover:bg-indigo-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Registrar Cámara
                    </a>
                </div>
                <svg class="absolute right-0 bottom-0 w-32 h-32 text-white/10 transform translate-x-8 translate-y-8 rotate-12 group-hover:scale-110 transition-transform duration-500" fill="currentColor" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl p-6">
                <h4 class="font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Recordatorio
                </h4>
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    Si una cámara aparece como <span class="font-mono text-red-500">Offline</span>, repórtalo al equipo de Mantenimiento para su revisión física.
                </p>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                <h3 class="font-bold text-slate-800 dark:text-white">Últimas Instalaciones</h3>
                <a href="{{ route('supervisor.cameras.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Ver todas</a>
            </div>
            
            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($recentCameras as $camera)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="p-2 rounded-lg {{ $camera->status ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600' : 'bg-slate-100 dark:bg-slate-700 text-slate-500' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $camera->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $camera->location ?? 'Sin ubicación' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <span class="text-xs text-slate-400 hidden sm:block">{{ $camera->created_at->diffForHumans() }}</span>
                            <a href="{{ route('supervisor.cameras.show', $camera) }}" class="p-2 text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Ver">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                        No hay registros recientes.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection