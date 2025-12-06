@extends('components.layouts.app')

@section('titulo', 'Nuevo Personal')

@section('contenido')

    <div class="max-w-2xl mx-auto">
        
        <div class="mb-6">
            <a href="{{ route('admin.personal.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Volver a la lista
            </a>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 to-teal-600"></div>

            <div class="p-8">
                <div class="flex items-center gap-4 mb-8">
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Registrar Personal</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Crea una cuenta para un nuevo colaborador.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.personal.store') }}">
                    @csrf

                    <div class="space-y-6">
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nombre Completo</label>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border @error('name') border-red-500 dark:border-red-500 @else border-slate-200 dark:border-slate-700 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-slate-900 dark:text-white placeholder-slate-400 transition-all" 
                                placeholder="Ej: Juan Pérez">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border @error('email') border-red-500 dark:border-red-500 @else border-slate-200 dark:border-slate-700 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-slate-900 dark:text-white placeholder-slate-400 transition-all" 
                                placeholder="usuario@empresa.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Rol Asignado</label>
                                <select name="role_id" id="roleSelect" onchange="toggleSupervisor()" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="supervisorDiv">
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Supervisor a Cargo</label>
                                <select name="supervisor_id" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-slate-500 mt-1">Requerido para roles operativos.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Contraseña</label>
                                <input type="password" name="password" required 
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border @error('password') border-red-500 dark:border-red-500 @else border-slate-200 dark:border-slate-700 @enderror focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-slate-900 dark:text-white transition-all"
                                    placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" required 
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none text-slate-900 dark:text-white transition-all"
                                    placeholder="Repite la contraseña">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-500/30 transform transition hover:-translate-y-0.5 active:translate-y-0">
                                Crear Usuario
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleSupervisor() {
            const roleSelect = document.getElementById('roleSelect');
            const supervisorDiv = document.getElementById('supervisorDiv');
            const selectedText = roleSelect.options[roleSelect.selectedIndex].text.toLowerCase();

            // Si es 'supervisor' o 'admin' (aunque admin no está en la lista), ocultamos el campo supervisor
            if (selectedText.includes('supervisor') || selectedText.includes('admin')) {
                supervisorDiv.style.opacity = '0.5';
                supervisorDiv.style.pointerEvents = 'none';
                supervisorDiv.querySelector('select').value = '';
            } else {
                supervisorDiv.style.opacity = '1';
                supervisorDiv.style.pointerEvents = 'auto';
            }
        }
        
        // Ejecutar al cargar para establecer estado inicial
        document.addEventListener('DOMContentLoaded', toggleSupervisor);
    </script>

@endsection