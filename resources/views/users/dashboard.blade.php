@extends('components.layouts.app')

@section('titulo', 'Mi Panel')

@section('contenido')

    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                Hola, {{ Auth::user()->name }} 👋
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg">
                Listo para el monitoreo. Aquí tienes tus accesos directos.
            </p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider">Fecha actual</p>
            <p class="text-xl font-bold text-slate-700 dark:text-slate-200">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <a href="{{ route('user.cameras.index') }}" class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 p-8 text-white shadow-xl transition-all hover:scale-[1.02] hover:shadow-blue-500/25">
            <div class="relative z-10">
                <div class="mb-6 inline-flex rounded-2xl bg-white/20 p-4 backdrop-blur-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold">Monitor de Cámaras</h2>
                <p class="mt-2 text-blue-100">Accede al listado de dispositivos y visualiza las transmisiones en tiempo real.</p>
                
                <div class="mt-8 inline-flex items-center gap-2 rounded-lg bg-white/20 px-5 py-2.5 text-sm font-bold backdrop-blur-md transition-colors group-hover:bg-white group-hover:text-blue-700">
                    Ver Cámaras <span aria-hidden="true">&rarr;</span>
                </div>
            </div>
            
            <div class="absolute -right-10 -bottom-10 h-64 w-64 rounded-full bg-white/10 blur-3xl group-hover:bg-white/20 transition-all"></div>
        </a>

        <div class="rounded-3xl bg-white dark:bg-slate-800 p-8 shadow-lg border border-slate-100 dark:border-slate-700 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-16 w-16 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-2xl font-bold text-slate-600 dark:text-slate-300">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Sesión iniciada como</p>
                        <p class="text-xl font-bold text-slate-900 dark:text-white">{{ Auth::user()->email }}</p>
                        <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-0.5 text-xs font-medium text-slate-800 dark:text-slate-300 mt-1">
                            {{ ucfirst(Auth::user()->role->name) }}
                        </span>
                    </div>
                </div>
                <p class="text-slate-600 dark:text-slate-400">
                    Recuerda cerrar sesión al terminar tu turno para mantener la seguridad del sistema.
                </p>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="mt-8">
                @csrf
                <button class="w-full rounded-xl border border-slate-200 dark:border-slate-600 py-3 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>

    </div>

@endsection