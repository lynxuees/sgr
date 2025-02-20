@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center">Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}" class="mt-4">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" name="email" id="email" required
                       class="mt-1 block w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input type="password" name="password" id="password" required
                       class="mt-1 block w-full px-4 py-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label for="remember" class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">Olvidaste tu contraseña?</a>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                Iniciar Sesión
            </button>
        </form>
    </div>
@endsection
