@extends('layouts.app')

@section('title', 'Panel de Control')
@section('page-title', 'Administración de SGR')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Bienvenido a SGR</h2>
        <p class="mt-4 text-darkSecondary">Monitorea la recolección de residuos y gestión de reciclaje.</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
            <div class="bg-blue-600 text-white p-5 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Usuarios Activos</h3>
                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
            </div>
            <div class="bg-green-600 text-white p-5 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Residuos Recolectados</h3>
                <p class="text-3xl font-bold">{{ $collectedSolids }} kg - {{ $collectedFluids }} m³</p>
            </div>
            <div class="bg-yellow-600 text-white p-5 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Recolecciones Completadas</h3>
                <p class="text-3xl font-bold">{{ $totalCompletedCollections }}</p>
            </div>
            <div class="bg-purple-600 text-white p-5 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold">Residuos Procesados</h3>
                <p class="text-3xl font-bold">{{ $processedSolids }} kg - {{ $processedFluids }} m³</p>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-darkSurface p-5 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-darkText">Últimas Recolecciones</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($latestCollections as $collection)
                        <li class="p-3 bg-darkBackground shadow rounded-lg flex justify-between items-center">
                            <div>
                                <strong class="text-darkText">{{ $collection->waste->description }}</strong>
                                <p class="text-sm text-darkSecondary">
                                    Recolectado por <span class="text-darkPrimary">{{ $collection->collector->name }}</span>
                                    ({{ $collection->created_at->diffForHumans() }})
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-darkSurface p-5 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-darkText">Recolecciones por tipo de residuo</h3>
                <div class="relative h-64">
                    <canvas id="wasteChart"></canvas>
                </div>
            </div>
            <div class="bg-darkSurface p-5 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-darkText">Clasificación de Residuos (Sólidos)</h3>
                <div class="relative h-64">
                    <canvas id="classificationChart"></canvas>
                </div>
            </div>
            <div class="bg-darkSurface p-5 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-darkText">Origen de Residuos (Sólidos)</h3>
                <div class="relative h-64">
                    <canvas id="originChart"></canvas>
                </div>
            </div>
            <div class="bg-darkSurface p-5 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-darkText">Clasificación de Residuos (Líquido/Gaseoso)</h3>
                <div class="relative h-64">
                    <canvas id="classificationChartFluid"></canvas>
                </div>
            </div>
            <div class="bg-darkSurface p-5 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-darkText">Origen de Residuos (Líquido/Gaseoso)</h3>
                <div class="relative h-64">
                    <canvas id="originChartFluid"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function reorderData(originalLabels, originalQuantities, order) {
                let newLabels = [];
                let newQuantities = [];
                order.forEach(function(item) {
                    let index = originalLabels.indexOf(item);
                    if (index !== -1) {
                        newLabels.push(item);
                        newQuantities.push(originalQuantities[index]);
                    }
                });
                return { labels: newLabels, quantities: newQuantities };
            }

            let classificationOrder = ["Ordinario", "Reciclable", "Peligroso"];
            let originOrder = ["Comercial", "Residencial", "Industrial"];

            let doughnutColors = [
                "#4C8BB0", "#70AE6E", "#BF616A", "#D08770",
                "#EBCB8B", "#A3BE8C", "#88C0D0", "#5E81AC"
            ];

            new Chart(document.getElementById("wasteChart").getContext("2d"), {
                type: "doughnut",
                data: {
                    labels: @json($wasteCollectionCount->pluck('name')),
                    datasets: [{
                        label: "",
                        data: @json($wasteCollectionCount->pluck('total_collections')),
                        backgroundColor: doughnutColors,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: { color: '#fff' }
                        },
                        tooltip: {
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            backgroundColor: 'rgba(0,0,0,0.8)'
                        }
                    }
                }
            });

            let classificationColors = {
                "Ordinario": "#56ccf2",
                "Reciclable": "#6fcf97",
                "Peligroso": "#eb5757"
            };

            let originColors = {
                "Industrial": "#d08770",
                "Comercial": "#88c0d0",
                "Residencial": "#a3be8c"
            };

            let classificationLabelsSolid = @json($classificationDataSolid->pluck('classification'));
            let classificationQuantitiesSolid = @json($classificationDataSolid->pluck('total_quantity'));
            let solidClassificationOrdered = reorderData(classificationLabelsSolid, classificationQuantitiesSolid, classificationOrder);
            let classificationBackgroundColorsSolid = solidClassificationOrdered.labels.map(
                label => classificationColors[label] || "#cccccc"
            );

            new Chart(document.getElementById("classificationChart").getContext("2d"), {
                type: "bar",
                data: {
                    labels: solidClassificationOrdered.labels,
                    datasets: [{
                        label: "",
                        data: solidClassificationOrdered.quantities,
                        backgroundColor: classificationBackgroundColorsSolid,
                        borderColor: '#1a1a1a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y !== undefined ? context.parsed.y : 0;
                                    return "Cantidad: " + value + " kg";
                                }
                            }
                        }
                    },
                    scales: {
                        x: { ticks: { color: '#fff' }, grid: { color: '#3a3a3a' } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#fff', callback: function(value) { return value + " kg"; } },
                            grid: { color: '#3a3a3a' }
                        }
                    }
                }
            });

            let originLabelsSolid = @json($originDataSolid->pluck('origin'));
            let originQuantitiesSolid = @json($originDataSolid->pluck('total_quantity'));
            let solidOriginOrdered = reorderData(originLabelsSolid, originQuantitiesSolid, originOrder);
            let originBackgroundColorsSolid = solidOriginOrdered.labels.map(
                label => originColors[label] || "#cccccc"
            );

            new Chart(document.getElementById("originChart").getContext("2d"), {
                type: "bar",
                data: {
                    labels: solidOriginOrdered.labels,
                    datasets: [{
                        label: "",
                        data: solidOriginOrdered.quantities,
                        backgroundColor: originBackgroundColorsSolid,
                        borderColor: '#1a1a1a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y !== undefined ? context.parsed.y : 0;
                                    return "Cantidad: " + value + " kg";
                                }
                            }
                        }
                    },
                    scales: {
                        x: { ticks: { color: '#fff' }, grid: { color: '#3a3a3a' } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#fff', callback: function(value) { return value + " kg"; } },
                            grid: { color: '#3a3a3a' }
                        }
                    }
                }
            });

            let classificationLabelsFluid = @json($classificationDataFluid->pluck('classification'));
            let classificationQuantitiesFluid = @json($classificationDataFluid->pluck('total_quantity'));
            let fluidClassificationOrdered = reorderData(classificationLabelsFluid, classificationQuantitiesFluid, classificationOrder);
            let classificationBackgroundColorsFluid = fluidClassificationOrdered.labels.map(
                label => classificationColors[label] || "#cccccc"
            );

            new Chart(document.getElementById("classificationChartFluid").getContext("2d"), {
                type: "bar",
                data: {
                    labels: fluidClassificationOrdered.labels,
                    datasets: [{
                        label: "",
                        data: fluidClassificationOrdered.quantities,
                        backgroundColor: classificationBackgroundColorsFluid,
                        borderColor: '#1a1a1a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y !== undefined ? context.parsed.y : 0;
                                    return "Cantidad: " + value + " m³";
                                }
                            }
                        }
                    },
                    scales: {
                        x: { ticks: { color: '#fff' }, grid: { color: '#3a3a3a' } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#fff', callback: function(value) { return value + " m³"; } },
                            grid: { color: '#3a3a3a' }
                        }
                    }
                }
            });

            let originLabelsFluid = @json($originDataFluid->pluck('origin'));
            let originQuantitiesFluid = @json($originDataFluid->pluck('total_quantity'));
            let fluidOriginOrdered = reorderData(originLabelsFluid, originQuantitiesFluid, originOrder);
            let originBackgroundColorsFluid = fluidOriginOrdered.labels.map(
                label => originColors[label] || "#cccccc"
            );

            new Chart(document.getElementById("originChartFluid").getContext("2d"), {
                type: "bar",
                data: {
                    labels: fluidOriginOrdered.labels,
                    datasets: [{
                        label: "",
                        data: fluidOriginOrdered.quantities,
                        backgroundColor: originBackgroundColorsFluid,
                        borderColor: '#1a1a1a',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y !== undefined ? context.parsed.y : 0;
                                    return "Cantidad: " + value + " m³";
                                }
                            }
                        }
                    },
                    scales: {
                        x: { ticks: { color: '#fff' }, grid: { color: '#3a3a3a' } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#fff', callback: function(value) { return value + " m³"; } },
                            grid: { color: '#3a3a3a' }
                        }
                    }
                }
            });
        });
    </script>
@endsection
