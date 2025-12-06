<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Videovigilancia')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <!-- NAV -->
    <nav class="bg-white shadow px-6 py-3 flex justify-between items-center">
        <div class="font-bold text-xl">Videovigilancia</div>

        @auth
        <div class="flex items-center gap-4">

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600">Admin</a>
            @else
                <a href="{{ route('users.dashboard') }}" class="text-blue-600">Mi panel</a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-red-600">Cerrar sesión</button>
            </form>
        </div>
        @endauth
    </nav>

    <!-- CONTENIDO -->
    <div class="container mx-auto mt-6">
        @yield('contenido')
    </div>

</body>
</html>
