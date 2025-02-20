<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGR - Inicio de Sesión')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<main class="w-full max-w-md">
    @yield('content')
</main>

<footer class="absolute bottom-4 text-center text-gray-600 w-full">
    &copy; {{ date('Y') }} SGR - Todos los derechos reservados
</footer>

</body>
</html>
