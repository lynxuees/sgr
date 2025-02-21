@extends('layouts.guest')

@section('title', 'Iniciar Sesión - SGR')

@section('content')
    <div class="bg-darkSurface p-6 rounded-lg">
        <h2 class="text-3xl font-bold text-center text-darkPrimary">SGR</h2>
        <p class="text-center text-darkText mt-2">Sistema de Gestión de Residuos</p>

        <form method="POST" action="{{ route('login') }}" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-darkText">Correo Electrónico</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    required
                    class="mt-1 block w-full px-4 py-2 bg-darkSurface border border-darkBorder rounded-lg text-darkText focus:outline-none focus:ring-2 focus:ring-darkPrimary"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-darkText">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="mt-1 block w-full px-4 py-2 bg-darkSurface border border-darkBorder rounded-lg text-darkText focus:outline-none focus:ring-2 focus:ring-darkPrimary"
                >
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label for="remember" class="flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        class="h-4 w-4 text-darkPrimary focus:ring-darkPrimary"
                    >
                    <span class="ml-2 text-sm text-darkText">Recordarme</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-link hover:underline">
                    Olvidaste tu contraseña?
                </a>
            </div>

            <button
                type="submit"
                class="w-full bg-darkPrimary text-white py-2 rounded-lg hover:bg-darkPrimaryHover transition font-semibold"
            >
                Iniciar Sesión
            </button>
        </form>
    </div>
@endsection
