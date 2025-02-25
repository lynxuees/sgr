@extends('layouts.app')

@section('title', 'Reporte de Recolecciones')
@section('page-title', 'Descargar Reporte de Recolecciones')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText mb-4">Reporte de Recolecciones</h2>
        <p class="text-darkText mb-6">
            Haz clic en el siguiente botón para descargar en formato Excel toda la información correspondiente a las recolecciones de residuos.
        </p>
        <div class="flex justify-center">
            <a href="{{ route('reports.collections.download') }}" class="bg-darkPrimary text-white px-6 py-3 rounded-md flex items-center gap-2">
                <i data-lucide="download" class="icon-small"></i>
                Descargar Reporte
            </a>
        </div>
    </div>
@endsection
