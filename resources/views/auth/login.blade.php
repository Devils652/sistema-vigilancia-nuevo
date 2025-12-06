@extends('components.layouts.guest')

@section('titulo', 'Iniciar Sesión')

@section('contenido')
    <div class="flex-grow flex items-center justify-center p-4">
        <div class="w-full max-w-md">

            <div class="flex justify-center mb-8">
                <div class="bg-blue-600 text-white p-3 rounded-2xl shadow-xl shadow-blue-500/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl border border-white/20 dark:border-slate-700 rounded-3xl shadow-2xl overflow-hidden">
                <div class="p-8 sm:p-10">
                                <!-- Botón para retroceder a la página de inicio -->
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 mb-6 text-sm text-slate-600 dark:text-slate-300 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Volver a inicio
            </a>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white text-center mb-2">Bienvenido de nuevo</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-center text-sm mb-8">Ingresa tus credenciales para acceder al sistema.</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Correo Electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all"
                                    placeholder="usuario@empresa.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Contraseña</label>
                                <input id="password" type="password" name="password" required autocomplete="current-password"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 outline-none transition-all"
                                    placeholder="••••••••">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection