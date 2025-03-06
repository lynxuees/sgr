@extends('layouts.guest')

@section('title', 'Login - SGR')

@section('content')
    @if(auth()->check())
        <script>
            window.location.href = "{{ route('dashboard') }}";
        </script>
    @endif

    <div class="bg-darkSurface p-6 rounded-lg">
        <h2 class="text-3xl font-bold text-center text-darkPrimary">SGR</h2>
        <p class="text-center text-darkText mt-2">Sistema de Gestión de Residuos</p>

        @if(session('success'))
            <div class="mb-4 text-green-500 text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 text-red-500 text-center font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-darkText">Correo Electrónico</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="mt-1 block w-full px-4 py-2 bg-darkSurface border border-darkBorder rounded-lg text-darkText focus:outline-none focus:ring-2 focus:ring-darkPrimary"
                >
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-darkText">Contraseña</label>
                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="mt-1 block w-full px-4 py-2 bg-darkSurface border border-darkBorder rounded-lg text-darkText focus:outline-none focus:ring-2 focus:ring-darkPrimary pr-10"
                    >
                    <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-3 flex items-center text-darkText focus:outline-none">
                        <i id="eyeIcon" data-lucide="eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between">
                <label for="remember" class="flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 text-darkPrimary focus:ring-darkPrimary"
                    >
                    <span class="ml-2 text-sm text-darkText">Recordarme</span>
                </label>
            </div>

            <button
                type="submit"
                class="w-full bg-darkPrimary text-white py-2 rounded-lg hover:bg-darkPrimaryHover transition font-semibold"
            >
                Iniciar Sesión
            </button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let passwordInput = document.getElementById('password');
            let togglePassword = document.getElementById('togglePassword');
            let eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.setAttribute("data-lucide", "eye-off");
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.setAttribute("data-lucide", "eye");
                }

                window.createIcons({ icons: window.icons });
            });
        });
    </script>
@endsection
