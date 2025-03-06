@extends('layouts.app')

@section('title', 'Gestión de Colecciones')
@section('page-title', 'Administración de Recolecciones')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Lista de Recolecciones</h2>
        <div class="mt-4 flex justify-end">
            <button id="openCreateModal" data-url="{{ route('collections.store') }}" class="bg-darkPrimary text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i data-lucide="plus" class="icon-small"></i> Agregar Recolección
            </button>
        </div>
        <div class="overflow-x-auto">
            <table id="collectionsTable" class="datatable w-full text-left bg-darkSurface border-collapse">
                <thead>
                <tr>
                    <th class="px-3 py-2 border-b">ID</th>
                    <th class="px-3 py-2 border-b">Residuo</th>
                    <th class="px-3 py-2 border-b">Recolector</th>
                    <th class="px-3 py-2 border-b">Centro</th>
                    <th class="px-3 py-2 border-b">Cantidad</th>
                    <th class="px-3 py-2 border-b">Unidad</th>
                    <th class="px-3 py-2 border-b">Tipo</th>
                    <th class="px-3 py-2 border-b">Clasificación</th>
                    <th class="px-3 py-2 border-b">Estado</th>
                    <th class="px-3 py-2 border-b">Origen</th>
                    <th class="px-3 py-2 border-b">Frecuencia</th>
                    <th class="px-3 py-2 border-b">Horario</th>
                    <th class="px-3 py-2 border-b">Status</th>
                    <th class="px-3 py-2 border-b">Fecha</th>
                    <th class="px-3 py-2 border-b">Localización</th>
                    <th class="px-3 py-2 border-b">Creación</th>
                    <th class="px-3 py-2 border-b text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($collections as $collection)
                    <tr class="border-b border-gray-700">
                        <td class="px-3 py-2">{{ $collection->id }}</td>
                        <td class="px-3 py-2">{{ $collection->waste->description ?? 'N/A' }}</td>
                        <td class="px-3 py-2">{{ $collection->collector->name ?? 'N/A' }}</td>
                        <td class="px-3 py-2">{{ $collection->disposal->name ?? 'N/A' }}</td>
                        <td class="px-3 py-2">{{ $collection->quantity }}</td>
                        <td class="px-3 py-2">{{ $collection->unit }}</td>
                        <td class="px-3 py-2">{{ $collection->type }}</td>
                        <td class="px-3 py-2">{{ $collection->classification }}</td>
                        <td class="px-3 py-2">{{ $collection->state }}</td>
                        <td class="px-3 py-2">{{ $collection->origin }}</td>
                        <td class="px-3 py-2">{{ $collection->frequency }}</td>
                        <td class="px-3 py-2">{{ $collection->schedule }}</td>
                        <td class="px-3 py-2">
                            @if ($collection->deleted_at)
                                <span class="text-darkWarning">Deshabilitado</span>
                            @else
                                <span class="text-darkSuccess">{{ $collection->status }}</span>
                            @endif
                        </td>
                        <td class="px-3 py-2">{{ \Carbon\Carbon::parse($collection->date)->format('d/m/Y') }}</td>
                        <td class="px-3 py-2">{{ $collection->location }}</td>
                        <td class="px-3 py-2">{{ $collection->created_at->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 flex justify-center gap-2">
                            @if ($collection->deleted_at)
                                <form action="{{ route('collections.restore', $collection->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="text-darkPrimary" title="Restaurar">
                                        <i data-lucide="rotate-cw" class="icon-small"></i>
                                    </button>
                                </form>
                                <form action="{{ route('collections.forceDelete', $collection->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-darkDanger" title="Eliminar Permanentemente">
                                        <i data-lucide="trash-2" class="icon-small"></i>
                                    </button>
                                </form>
                            @else
                                <button class="openEditModal text-darkPrimary" title="Editar"
                                        data-id="{{ $collection->id }}"
                                        data-waste_id="{{ $collection->waste_id }}"
                                        data-collector_id="{{ $collection->collector_id }}"
                                        data-disposal_id="{{ $collection->disposal_id }}"
                                        data-quantity="{{ $collection->quantity }}"
                                        data-unit="{{ $collection->unit }}"
                                        data-type="{{ $collection->type }}"
                                        data-classification="{{ $collection->classification }}"
                                        data-state="{{ $collection->state }}"
                                        data-origin="{{ $collection->origin }}"
                                        data-frequency="{{ $collection->frequency }}"
                                        data-schedule="{{ $collection->schedule }}"
                                        data-status="{{ $collection->status }}"
                                        data-date="{{ \Carbon\Carbon::parse($collection->date)->format('Y-m-d') }}"
                                        data-location="{{ $collection->location }}"
                                        data-url="{{ route('collections.update', $collection->id) }}">
                                    <i data-lucide="edit" class="icon-small"></i>
                                </button>
                                <form action="{{ route('collections.destroy', $collection->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-darkDanger" title="Deshabilitar">
                                        <i data-lucide="trash" class="icon-small"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal de Crear/Editar Colección -->
        <div id="collectionModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-darkSurface p-6 rounded-lg shadow-lg w-1/3 max-h-[90vh] overflow-y-auto">
                <h2 id="modalTitle" class="text-xl font-semibold text-darkText"></h2>
                <form id="collectionForm" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-darkText">Residuo <span class="text-red-500">*</span>:</label>
                            <select name="waste_id" id="waste_id" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                @foreach ($wastes as $waste)
                                    <option value="{{ $waste->id }}">{{ $waste->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Recolector <span class="text-red-500">*</span>:</label>
                            <select name="collector_id" id="collector_id" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                @foreach ($collectors as $collector)
                                    <option value="{{ $collector->id }}">{{ $collector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Centro de Disposición <span class="text-red-500">*</span>:</label>
                            <select name="disposal_id" id="disposal_id" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                @foreach ($disposals as $disposal)
                                    <option value="{{ $disposal->id }}">{{ $disposal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Cantidad <span class="text-red-500">*</span>:</label>
                            <input type="number" name="quantity" id="quantity" class="w-full p-2 rounded bg-darkBackground text-darkText border" min="1" required>
                        </div>
                        <div>
                            <label class="block text-darkText">Unidad <span class="text-red-500">*</span>:</label>
                            <select name="unit" id="unit" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="T">T</option>
                                <option value="Kg">Kg</option>
                                <option value="L">L</option>
                                <option value="m³">m³</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Tipo <span class="text-red-500">*</span>:</label>
                            <select name="type" id="type" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Generado">Generado</option>
                                <option value="Reciclado">Reciclado</option>
                                <option value="Eliminado">Eliminado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Clasificación <span class="text-red-500">*</span>:</label>
                            <select name="classification" id="classification" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Ordinario">Ordinario</option>
                                <option value="Reciclable">Reciclable</option>
                                <option value="Peligroso">Peligroso</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Estado <span class="text-red-500">*</span>:</label>
                            <select name="state" id="state" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Sólido">Sólido</option>
                                <option value="Líquido">Líquido</option>
                                <option value="Gaseoso">Gaseoso</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Origen <span class="text-red-500">*</span>:</label>
                            <select name="origin" id="origin" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Industrial">Industrial</option>
                                <option value="Comercial">Comercial</option>
                                <option value="Residencial">Residencial</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Frecuencia <span class="text-red-500">*</span>:</label>
                            <select name="frequency" id="frequency" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Diario">Diario</option>
                                <option value="Semanal">Semanal</option>
                                <option value="Mensual">Mensual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Horario <span class="text-red-500">*</span>:</label>
                            <select name="schedule" id="schedule" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Status <span class="text-red-500">*</span>:</label>
                            <select name="status" id="status" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                                <option value="Programado">Programado</option>
                                <option value="En camino">En camino</option>
                                <option value="Completado">Completado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-darkText">Fecha <span class="text-red-500">*</span>:</label>
                            <input type="date" name="date" id="date" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                        </div>
                        <div>
                            <label class="block text-darkText">Localización <span class="text-red-500">*</span>:</label>
                            <input type="text" name="location" id="location" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" id="closeModal" class="bg-gray-600 text-white px-4 py-2 rounded-md">Cancelar</button>
                        <button type="submit" class="bg-darkPrimary text-white px-4 py-2 rounded-md">Guardar</button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                $("#collectionsTable").DataTable({
                    language: {
                        search: "Buscar:",
                        lengthMenu: "Mostrar _MENU_ registros por página",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        zeroRecords: "No se encontraron registros",
                        emptyTable: "No hay datos disponibles en la tabla"
                    }
                });

                $("#openCreateModal").on("click", function () {
                    let url = $(this).data("url");
                    openModal("Crear Recolección", url, "POST", {});
                });

                $(document).on("click", ".openEditModal", function () {
                    let data = {
                        waste_id: $(this).data("waste_id"),
                        collector_id: $(this).data("collector_id"),
                        disposal_id: $(this).data("disposal_id"),
                        quantity: $(this).data("quantity"),
                        unit: $(this).data("unit"),
                        type: $(this).data("type"),
                        classification: $(this).data("classification"),
                        state: $(this).data("state"),
                        origin: $(this).data("origin"),
                        frequency: $(this).data("frequency"),
                        schedule: $(this).data("schedule"),
                        status: $(this).data("status"),
                        date: $(this).data("date"),
                        location: $(this).data("location"),
                    };
                    let url = $(this).data("url");
                    openModal("Editar Recolección", url, "PUT", data);
                });

                function openModal(title, action, method, data) {
                    $("#modalTitle").text(title);
                    $("#collectionForm").attr("action", action);
                    $("#formMethod").val(method);
                    $("#waste_id").val(data.waste_id || "");
                    $("#collector_id").val(data.collector_id || "");
                    $("#disposal_id").val(data.disposal_id || "");
                    $("#quantity").val(data.quantity || "");
                    $("#unit").val(data.unit || "T");
                    $("#type").val(data.type || "Generado");
                    $("#classification").val(data.classification || "Ordinario");
                    $("#state").val(data.state || "Sólido");
                    $("#origin").val(data.origin || "Industrial");
                    $("#frequency").val(data.frequency || "Diario");
                    $("#schedule").val(data.schedule || "Mañana");
                    $("#status").val(data.status || "Programado");
                    $("#date").val(data.date || "");
                    $("#location").val(data.location || "");
                    $("#collectionModal").removeClass("hidden");
                }

                $("#closeModal").on("click", function () {
                    $("#collectionModal").addClass("hidden");
                });

                $("#collectionForm").validate({
                    rules: {
                        waste_id: { required: true },
                        collector_id: { required: true },
                        disposal_id: { required: true },
                        quantity: { required: true, number: true, min: 1 },
                        unit: { required: true },
                        type: { required: true },
                        classification: { required: true },
                        state: { required: true },
                        origin: { required: true },
                        frequency: { required: true },
                        schedule: { required: true },
                        status: { required: true },
                        date: { required: true, date: true },
                        location: { required: true, minlength: 3, maxlength: 255 }
                    },
                    messages: {
                        waste_id: { required: "El residuo es obligatorio." },
                        collector_id: { required: "El recolector es obligatorio." },
                        disposal_id: { required: "El centro de disposición es obligatorio." },
                        quantity: {
                            required: "La cantidad es obligatoria.",
                            number: "Debe ser un número válido.",
                            min: "La cantidad debe ser al menos 1."
                        },
                        unit: { required: "La unidad es obligatoria." },
                        type: { required: "El tipo es obligatorio." },
                        classification: { required: "La clasificación es obligatoria." },
                        state: { required: "El estado es obligatorio." },
                        origin: { required: "El origen es obligatorio." },
                        frequency: { required: "La frecuencia es obligatoria." },
                        schedule: { required: "El horario es obligatorio." },
                        status: { required: "El status es obligatorio." },
                        date: { required: "La fecha es obligatoria.", date: "Debe ser una fecha válida." },
                        location: {
                            required: "La localización es obligatoria.",
                            minlength: "La localización debe tener al menos 3 caracteres.",
                            maxlength: "La localización no puede superar los 255 caracteres."
                        }
                    }
                });
            });


        </script>
@endsection
