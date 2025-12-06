@extends('components.layouts.base')
@section('titulo', 'Registro')

@section('contenido')
<div class="card col-md-6 mx-auto">
    <div class="card-body">
        <h4 class="mb-3">Registro de usuario</h4>
        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <input type="text" name="name" class="form-control mb-2" placeholder="Nombre" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Correo" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>
            <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Confirmar contraseña" required>
            <button class="btn btn-primary w-100">Registrarse</button>
        </form>
    </div>
</div>
@endsection
