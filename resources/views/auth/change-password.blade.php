@extends('components.layouts.app')

@section('titulo','Cambiar contraseña')

@section('contenido')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Cambiar contraseña</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.change.post') }}">
        @csrf

        <label>Contraseña actual</label>
        <input type="password" name="current" class="input" required>

        <label class="mt-3">Nueva contraseña</label>
        <input type="password" name="password" class="input" required>

        <label class="mt-3">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="input" required>

        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded w-full">
            Guardar cambios
        </button>
    </form>
</div>
@endsection
