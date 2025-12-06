@extends('components.layouts.app')

@section('titulo', 'Video Wall - Monitoreo')

@section('contenido')

    @php
        $role = Auth::user()->role->name ?? 'user';
        $prefix = match ($role) {
            'admin' => 'admin.',
            'supervisor' => 'supervisor.',
            'mantenimiento' => 'mantenimiento.',
            default => 'user.',
        };
        
        // --- LÓGICA DE GRID INTELIGENTE ---
        $count = $cameras->count();
        
        // Definimos las columnas según la cantidad de cámaras
        $gridClass = match (true) {
            $count === 1 => 'grid-cols-1 h-[70vh]',           // 1 cámara: Gigante
            $count === 2 => 'grid-cols-1 md:grid-cols-2 h-[60vh]', // 2 cámaras: Mitad y mitad
            $count <= 4  => 'grid-cols-2 h-[80vh]',           // 3-4 cámaras: 2x2
            $count <= 6  => 'grid-cols-2 md:grid-cols-3',     // 5-6 cámaras: 3 columnas
            default      => 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4', // +6 cámaras: 4 columnas
        };
    @endphp

    <div class="flex justify-between items-center mb-6 sticky top-24 z-30 bg-slate-50/90 dark:bg-slate-950/90 backdrop-blur-sm py-2 rounded-xl">
        <div>
             <h1 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                <div class="bg-red-600 text-white p-1.5 rounded-lg animate-pulse">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" /></svg>
                </div>
                Video Wall
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs font-mono mt-1">
                SEÑALES ACTIVAS: <span class="text-emerald-500 font-bold">{{ $count }}</span>
            </p>
        </div>
        <a href="{{ route($prefix . 'cameras.index') }}" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
            Volver a Lista
        </a>
    </div>

    @if($count > 0)
        <div class="grid gap-4 w-full {{ $gridClass }} auto-rows-fr">
            @foreach($cameras as $camera)
                @php
                    $videoData = \App\Helpers\VideoHelper::parseUrl($camera->ip);
                @endphp

                <div class="relative bg-black rounded-xl overflow-hidden shadow-2xl border border-slate-800 group w-full h-full min-h-[250px]">
                    
                    @if($videoData['isYoutube'])
                        <iframe src="{{ $videoData['streamUrl'] }}" class="w-full h-full pointer-events-none" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    @else
                        <img src="{{ $videoData['streamUrl'] }}" class="w-full h-full object-contain bg-black" alt="{{ $camera->name }}"
                             onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                        
                        <div class="hidden absolute inset-0 bg-slate-900 flex flex-col items-center justify-center text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                            <span class="text-sm font-mono uppercase tracking-widest">Sin Señal</span>
                        </div>
                    @endif

                    <div class="absolute top-2 left-2 px-3 py-1 bg-black/60 backdrop-blur-md rounded-lg border border-white/10 flex items-center gap-2 z-10">
                        <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                        <span class="text-white text-xs font-bold tracking-wide uppercase">{{ $camera->name }}</span>
                    </div>

                    <a href="{{ route($prefix . 'cameras.show', $camera) }}" class="absolute inset-0 flex items-center justify-center bg-black/0 hover:bg-black/40 transition-all duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all duration-300 drop-shadow-lg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-[60vh] text-center bg-slate-50 dark:bg-slate-900/50 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
            <div class="p-6 bg-slate-100 dark:bg-slate-800 rounded-full mb-6 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-700 dark:text-slate-200">Sin transmisiones</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-md mx-auto">Actualmente no hay cámaras con estado "Activo". Enciéndelas desde el inventario.</p>
        </div>
    @endif

@endsection