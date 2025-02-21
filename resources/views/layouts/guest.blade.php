<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGR - Inicio de Sesión')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-darkBackground text-darkText flex items-center justify-center min-h-screen">

<main class="w-full max-w-md">
    @yield('content')
</main>

<footer class="absolute bottom-4 text-center text-darkText w-full">
    &copy; {{ date('Y') }} SGR - Todos los derechos reservados
</footer>

</body>
</html>
