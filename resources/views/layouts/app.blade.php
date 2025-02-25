<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGR Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-darkBackground text-darkText min-h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-darkSurface text-darkText h-screen fixed top-0 left-0 shadow-lg">
    <div class="p-6 text-xl font-bold text-center">
        <span class="text-darkPrimary">SGR</span> Admin
    </div>
    <nav class="mt-4">
        <ul class="space-y-2">
            <li class="px-6 py-3 hover:bg-darkSidebarHover transition-colors duration-200 rounded-md mx-2 flex items-center space-x-3">
                <i data-lucide="home"></i>
                <a href="{{ route('dashboard') }}" class="block font-medium">Dashboard</a>
            </li>
            <li class="px-6 py-3 hover:bg-darkSidebarHover transition-colors duration-200 rounded-md mx-2 flex items-center space-x-3">
                <i data-lucide="users"></i>
                <a href="{{ route('users.index') }}" class="block font-medium">Usuarios</a>
            </li>
            <li class="px-6 py-3 hover:bg-darkSidebarHover transition-colors duration-200 rounded-md mx-2 flex items-center space-x-3">
                <i data-lucide="briefcase"></i>
                <a href="{{ route('roles.index') }}" class="block font-medium">Roles</a>
            </li>
            <li class="px-6 py-3 hover:bg-darkSidebarHover transition-colors duration-200 rounded-md mx-2 flex items-center space-x-3">
                <i data-lucide="recycle"></i>
                <a href="{{ route('wastes.index') }}" class="block font-medium">Residuos</a>
            </li>
            <li class="px-6 py-3 hover:bg-darkSidebarHover transition-colors duration-200 rounded-md mx-2 flex items-center space-x-3">
                <i data-lucide="truck"></i>
                <a href="{{ route('collections.index') }}" class="block font-medium">Recolecciones</a>
            </li>
            <li class="px-6 py-3 hover:bg-darkSidebarHover transition-colors duration-200 rounded-md mx-2 flex items-center space-x-3">
                <i data-lucide="bar-chart"></i>
                <a href="{{ route('reports.index') }}" class="block font-medium">Reportes</a>
            </li>
        </ul>
    </nav>
</aside>

<!-- Main wrapper -->
<div class="ml-64 flex flex-col min-h-screen">

    <!-- Header with margin from top (sticky + top-4) and fixed height (64px) -->
    <header class="sticky top-8 z-20 bg-transparent pl-[70px] pr-[70px] h-[80px] mb-8">
        <!-- Inner container occupying header height -->
        <div class="bg-darkSurface shadow-2xl rounded-md w-full h-full px-4 flex items-center justify-between">
            <div class="text-xl font-semibold">@yield('page-title', 'Dashboard')</div>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('logout') }}" class="text-darkText hover:underline">Cerrar sesión</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main content with 50px side padding -->
    <main class="flex-1 py-6 pl-[50px] pr-[50px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-4 text-darkText">
        &copy; {{ date('Y') }} SGR - Todos los derechos reservados
    </footer>
</div>


</body>
</html>
