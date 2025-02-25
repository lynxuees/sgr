@extends('layouts.app')

@section('title', 'Gestión de Tipos de Residuos')

@section('page-title', 'Administración de Tipos de Residuos')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Lista de Tipos de Residuos</h2>
        <div class="mt-4 flex justify-end">
            <button id="openCreateModal"
                    data-url="{{ route('waste_types.store') }}"
                    class="bg-darkPrimary text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i data-lucide="plus"></i> Agregar Tipo de Residuo
            </button>
        </div>
        <table id="wasteTypesTable" class="datatable w-full text-left bg-darkSurface border-collapse">
            <thead>
            <tr>
                <th class="px-3 py-2 border-b">ID</th>
                <th class="px-3 py-2 border-b">Nombre</th>
                <th class="px-3 py-2 border-b">Fecha de Creación</th>
                <th class="px-3 py-2 border-b">Estado</th>
                <th class="px-3 py-2 border-b text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($wasteTypes as $wasteType)
                <tr class="border-b border-gray-700">
                    <td class="px-3 py-2">{{ $wasteType->id }}</td>
                    <td class="px-3 py-2">{{ $wasteType->name }}</td>
                    <td class="px-3 py-2">{{ $wasteType->created_at->format('d/m/Y') }}</td>
                    <td class="px-3 py-2">
                        @if ($wasteType->deleted_at)
                            <span class="text-darkWarning">Deshabilitado</span>
                        @else
                            <span class="text-darkSuccess">Activo</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 flex justify-center gap-2">
                        @if ($wasteType->deleted_at)
                            <form action="{{ route('waste_types.restore', $wasteType->id) }}" method="POST" class="restoreWasteTypeForm">
                                @csrf
                                <button type="submit" class="text-darkPrimary" title="Restaurar">
                                    <i data-lucide="rotate-cw" class="icon-small"></i>
                                </button>
                            </form>
                            <form action="{{ route('waste_types.forceDelete', $wasteType->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-darkDanger" title="Eliminar Permanentemente">
                                    <i data-lucide="trash-2" class="icon-small"></i>
                                </button>
                            </form>
                        @else
                            <button class="openEditModal text-darkPrimary" title="Editar"
                                    data-id="{{ $wasteType->id }}"
                                    data-name="{{ $wasteType->name }}"
                                    data-url="{{ route('waste_types.update', $wasteType->id) }}">
                                <i data-lucide="edit" class="icon-small"></i>
                            </button>
                            <form action="{{ route('waste_types.destroy', $wasteType->id) }}" method="POST">
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

    <div id="wasteTypeModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-darkSurface p-6 rounded-lg shadow-lg w-1/3">
            <h2 id="modalTitle" class="text-xl font-semibold text-darkText"></h2>
            <form id="wasteTypeForm" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod">
                <label class="block text-darkText">Nombre <span class="text-red-500">*</span>:</label>
                <input type="text" name="name" id="name" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" id="closeModal" class="bg-gray-600 text-white px-4 py-2 rounded-md">Cancelar</button>
                    <button type="submit" class="bg-darkPrimary text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $("#wasteTypesTable").DataTable({
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
                openModal("Crear Tipo de Residuo", url, "POST", {});
            });

            $(document).on("click", ".openEditModal", function () {
                let wasteTypeId = $(this).data("id");
                let wasteTypeName = $(this).data("name");
                let url = $(this).data("url");
                openModal("Editar Tipo de Residuo", url, "PUT", { name: wasteTypeName });
            });

            function openModal(title, action, method, data) {
                $("#modalTitle").text(title);
                $("#wasteTypeForm").attr("action", action);
                $("#formMethod").val(method);
                $("#name").val(data.name || "");
                $("#wasteTypeModal").removeClass("hidden");
            }

            $("#closeModal").on("click", function () {
                $("#wasteTypeModal").addClass("hidden");
            });

            $("#wasteTypeForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    }
                },
                messages: {
                    name: {
                        required: "El nombre es obligatorio.",
                        minlength: "El nombre debe tener al menos 3 caracteres.",
                        maxlength: "El nombre no puede superar los 255 caracteres."
                    }
                }
            });
        });
    </script>
@endsection
