@extends('components.layouts.app')

@section('titulo', 'Nuevo Usuario')

@section('contenido')

    <div class="max-w-2xl mx-auto">
        
        <div class="mb-6">
            <a href="{{ route('admin.personal.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Cancelar
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="h-1.5 w-full bg-indigo-500"></div>

            <div class="p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Registrar Personal</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Crear un nuevo acceso al sistema.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.personal.store') }}">
                    @csrf

                    <div class="space-y-6">
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nombre Completo</label>
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none text-slate-900 dark:text-white transition-all placeholder-slate-400" 
                                placeholder="Ej: Juan Pérez">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none text-slate-900 dark:text-white transition-all placeholder-slate-400" 
                                placeholder="juan@empresa.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Contraseña</label>
                            <input type="password" name="password" required 
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none text-slate-900 dark:text-white transition-all">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Asignar Rol</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach($roles as $role)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="role_id" value="{{ $role->id }}" class="peer sr-only" required>
                                        <div class="p-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-600 rounded-lg peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 peer-checked:text-indigo-700 dark:peer-checked:text-indigo-300 hover:border-indigo-300 transition-all text-center">
                                            <span class="text-sm font-bold uppercase tracking-wide block">{{ ucfirst($role->name) }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('role_id')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Supervisor Asignado <span class="text-red-500">*</span>
                            </label>
                            <select name="supervisor_id" required class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none text-slate-900 dark:text-white">
                                <option value="" disabled selected>Seleccione un supervisor...</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                            @error('supervisor_id')
                                <p class="text-red-500 text-xs mt-1 font-medium">Debes seleccionar un supervisor.</p>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transform transition hover:-translate-y-0.5 active:translate-y-0">
                                Crear Usuario
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection