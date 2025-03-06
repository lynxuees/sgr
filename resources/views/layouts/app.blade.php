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
    <nav class="mt-4 space-y-6">

        <!-- Section: Principal (Visible para todos los usuarios) -->
        <div>
            <h3 class="text-xs uppercase text-darkSecondary px-6 mb-2">Principal</h3>
            <ul class="space-y-2">
                <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                    <i data-lucide="home"></i>
                    <a href="{{ route('dashboard') }}" class="block font-medium">Inicio</a>
                </li>
            </ul>
        </div>

        <!-- Section: Administración (Solo para Admin) -->
        @if(auth()->user()->hasRole('admin'))
            <div>
                <h3 class="text-xs uppercase text-darkSecondary px-6 mb-2">Administración</h3>
                <ul class="space-y-2">
                    <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                        <i data-lucide="users"></i>
                        <a href="{{ route('users.index') }}" class="block font-medium">Usuarios</a>
                    </li>
                    <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                        <i data-lucide="briefcase"></i>
                        <a href="{{ route('roles.index') }}" class="block font-medium">Roles</a>
                    </li>
                </ul>
            </div>
        @endif

        <!-- Section: Gestión de Residuos (Admin y Center Manager) -->
        @if(auth()->user()->hasRole(['admin', 'center_manager']))
            <div>
                <h3 class="text-xs uppercase text-darkSecondary px-6 mb-2">Gestión de Residuos</h3>
                <ul class="space-y-2">
                    @if(auth()->user()->hasRole('admin'))
                        <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                            <i data-lucide="recycle"></i>
                            <a href="{{ route('waste_types.index') }}" class="block font-medium">Tipos de Residuos</a>
                        </li>
                        <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                            <i data-lucide="trash-2"></i>
                            <a href="{{ route('wastes.index') }}" class="block font-medium">Gestión de Residuos</a>
                        </li>
                    @endif
                    <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                        <i data-lucide="landmark"></i>
                        <a href="{{ route('disposals.index') }}" class="block font-medium">Centros de Reciclaje</a>
                    </li>
                </ul>
            </div>
        @endif

        <!-- Section: Operaciones (Admin, Center Manager, Collector, Driver) -->
        @if(auth()->user()->hasRole(['admin', 'center_manager', 'collector', 'driver']))
            <div>
                <h3 class="text-xs uppercase text-darkSecondary px-6 mb-2">Operaciones</h3>
                <ul class="space-y-2">
                    <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                        <i data-lucide="truck"></i>
                        <a href="{{ route('collections.index') }}" class="block font-medium">Recolecciones</a>
                    </li>
                </ul>
            </div>
        @endif

        <!-- Section: Reportes (Todos excepto Cliente) -->
        @if(auth()->user()->hasRole(['admin', 'center_manager', 'collector', 'driver', 'viewer']))
            <div>
                <h3 class="text-xs uppercase text-darkSecondary px-6 mb-2">Reportes</h3>
                <ul class="space-y-2">
                    <li class="px-6 py-3 hover:bg-darkSidebarHover rounded-md flex items-center space-x-3">
                        <i data-lucide="bar-chart"></i>
                        <a href="{{ route('reports.index') }}" class="block font-medium">Reportes</a>
                    </li>
                </ul>
            </div>
        @endif

    </nav>
</aside>

<!-- Main wrapper -->
<div class="ml-64 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="sticky top-8 z-20 bg-transparent pl-[70px] pr-[70px] h-[80px] mb-8">
        <div class="bg-darkSurface shadow-2xl rounded-md w-full h-full px-4 flex items-center justify-between">
            <div class="text-xl font-semibold">@yield('page-title', 'Inicio')</div>
            <div class="flex items-center space-x-4">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-darkText hover:underline">
                            Cerrar sesión
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main content -->
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
