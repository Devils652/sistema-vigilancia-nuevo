@extends('components.layouts.app')

@section('titulo', 'Monitor en Vivo')

@section('contenido')
<div class="max-w-6xl mx-auto">

    @php
        // CORRECCIÓN: Detectar el prefijo correcto según el rol real
        $userRole = Auth::user()->role->name ?? 'user';
        $prefix = match ($userRole) {
            'admin' => 'admin.',
            'supervisor' => 'supervisor.',
            'mantenimiento' => 'mantenimiento.',
            default => 'user.',
        };

        $ip = trim($camera->ip);
        $isYoutube = false;
        $streamUrl = '';

        // Lógica de detección de video (YouTube / IP)
        if (str_contains($ip, 'youtube.com') || str_contains($ip, 'youtu.be')) {
            $isYoutube = true;
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $ip, $match);
            $videoId = $match[1] ?? null;
            $streamUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&controls=0&disablekb=1&modestbranding=1&rel=0&loop=1&playlist={$videoId}&mute=1";
        } elseif (str_starts_with($ip, 'http')) {
            $streamUrl = $ip;
        } elseif (str_contains($ip, ':8080')) {
            $streamUrl = "http://{$ip}/video";
        } else {
            $streamUrl = "http://{$ip}:81/stream";
        }
    @endphp

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex items-center gap-4">
            <div class="p-2.5 {{ $camera->status ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' }} rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    {{ $camera->name }}
                    @if($isYoutube)
                        <span class="px-2 py-0.5 bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 text-[10px] rounded font-bold border border-red-200 dark:border-red-800">DEMO</span>
                    @endif
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    {{ $camera->location ?? 'Ubicación desconocida' }}
                </p>
            </div>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route($prefix . 'cameras.index') }}" class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                Volver
            </a>
            
            @can('editar_camaras')
            <a href="{{ route($prefix . 'cameras.edit', $camera) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 shadow-md shadow-indigo-500/20 transition-colors">
                Configurar
            </a>
            @endcan
        </div>
    </div>

    <div class="bg-black rounded-2xl overflow-hidden shadow-2xl ring-1 ring-slate-900/10 dark:ring-slate-700 relative aspect-video group">
        @if($camera->status)
            @if($isYoutube)
                <div class="w-full h-full pointer-events-none"> 
                    <iframe src="{{ $streamUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @else
                <img src="{{ $streamUrl }}" class="w-full h-full object-contain bg-black" alt="Video en vivo"
                    onerror="this.style.display='none'; document.getElementById('error-msg').classList.remove('hidden');">
                
                <div id="error-msg" class="hidden absolute inset-0 flex flex-col items-center justify-center text-white bg-slate-900/90 backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <p class="text-lg font-bold">No se recibe señal</p>
                    <p class="text-sm text-slate-400 mt-1">Verifique que el dispositivo "{{ $camera->ip }}" esté encendido.</p>
                </div>
            @endif

            <div class="absolute top-4 left-4 flex items-center gap-2 px-3 py-1 bg-black/60 backdrop-blur-md rounded-full text-white text-xs font-bold tracking-wider border border-white/10">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                LIVE
            </div>
        @else
            <div class="absolute inset-0 flex flex-col items-center justify-center text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                <span class="font-mono tracking-widest text-sm opacity-50">SEÑAL DESCONECTADA</span>
            </div>
        @endif
    </div>
</div>
@endsection