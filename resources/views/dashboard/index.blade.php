@extends('layouts.app')

@section('title', 'Panel de Control')

@section('page-title', 'Administración de SGR')

@section('content')
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold">Bienvenido al Panel de Administración de SGR</h2>
        <p class="mt-4 text-gray-600">Monitorea la recolección de residuos, gestión de usuarios y procesos de reciclaje.</p>

        <!-- Quick stats -->
        <div class="grid grid-cols-4 gap-6 mt-6">
            <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Usuarios Activos</h3>
                <p class="text-2xl">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Residuos Generados</h3>
                <p class="text-2xl">
                    {{ \App\Models\Waste::whereMonth('created_at', now()->month)->count() }} kg
                </p>
            </div>
            <div class="bg-yellow-500 text-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Recolecciones Completadas</h3>
                <p class="text-2xl">
                    {{ \App\Models\Collection::where('status', 'Completado')->count() }}
                </p>
            </div>
            <div class="bg-purple-500 text-white p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold">Residuos Procesados</h3>
                <p class="text-2xl">
                    {{ \App\Models\Waste::where('status', 'Procesado')->count() }} kg
                </p>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="mt-8 bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-xl font-semibold">Últimas Recolecciones</h3>
            <ul class="mt-4 space-y-2">
                @foreach (\App\Models\Collection::latest()->limit(5)->get() as $collection)
                    <li class="p-2 bg-white shadow rounded-md">
                        <strong>{{ $collection->waste->description }}</strong> - Recolectado por {{ $collection->collector->name }}
                        <span class="text-sm text-gray-500">
                            ({{ $collection->created_at->diffForHumans() }})
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
