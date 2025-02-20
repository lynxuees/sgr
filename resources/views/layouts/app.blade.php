<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGR Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 flex">

<!-- Sidebar -->
<aside class="w-64 bg-blue-900 text-white h-screen fixed">
    <div class="p-4 text-lg font-bold text-center">
        SGR Admin
    </div>
    <nav>
        <ul>
            <li class="px-6 py-3 hover:bg-blue-700">
                <a href="{{ route('dashboard') }}" class="block">Panel de Control</a>
            </li>
            <li class="px-6 py-3 hover:bg-blue-700">
                <a href="{{ route('users.index') }}" class="block">Usuarios</a>
            </li>
            <li class="px-6 py-3 hover:bg-blue-700">
                <a href="{{ route('roles.index') }}" class="block">Roles</a>
            </li>
            <li class="px-6 py-3 hover:bg-blue-700">
                <a href="{{ route('wastes.index') }}" class="block">Residuos</a>
            </li>
            <li class="px-6 py-3 hover:bg-blue-700">
                <a href="{{ route('collections.index') }}" class="block">Recolecciones</a>
            </li>
            <li class="px-6 py-3 hover:bg-blue-700">
                <a href="{{ route('reports.index') }}" class="block">Reportes</a>
            </li>
        </ul>
    </nav>
</aside>

<!-- Main content -->
<div class="flex-1 ml-64">
    <!-- Navbar -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="text-xl font-semibold">
            @yield('page-title', 'Panel de Control')
        </div>
        <div>
            @auth
                <a href="{{ route('logout') }}" class="text-blue-600 hover:underline">Cerrar sesión</a>
            @endauth
        </div>
    </header>

    <!-- Content area -->
    <main class="p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-gray-600">
        &copy; {{ date('Y') }} SGR - Todos los derechos reservados
    </footer>
</div>

</body>
</html>
