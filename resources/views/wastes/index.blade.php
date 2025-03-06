@extends('layouts.app')

@section('title', 'Gestión de Residuos')
@section('page-title', 'Administración de Residuos')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Lista de Residuos</h2>
        <div class="mt-4 flex justify-end">
            <button id="openCreateModal" data-url="{{ route('wastes.store') }}" class="bg-darkPrimary text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i data-lucide="plus" class="icon-small"></i> Agregar Residuo
            </button>
        </div>
        <table id="wastesTable" class="datatable w-full text-left bg-darkSurface border-collapse">
            <thead>
            <tr>
                <th class="px-3 py-2 border-b">ID</th>
                <th class="px-3 py-2 border-b">Usuario</th>
                <th class="px-3 py-2 border-b">Tipo de Residuo</th>
                <th class="px-3 py-2 border-b">Descripción</th>
                <th class="px-3 py-2 border-b">Cantidad</th>
                <th class="px-3 py-2 border-b">Estado</th>
                <th class="px-3 py-2 border-b">Fecha de Creación</th>
                <th class="px-3 py-2 border-b text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($wastes as $waste)
                <tr class="border-b border-gray-700">
                    <td class="px-3 py-2">{{ $waste->id }}</td>
                    <td class="px-3 py-2">{{ $waste->user->name }}</td>
                    <td class="px-3 py-2">{{ $waste->wasteType->name }}</td> <!-- Cambio aquí -->
                    <td class="px-3 py-2">{{ $waste->description }}</td>
                    <td class="px-3 py-2">{{ $waste->quantity }}</td>
                    <td class="px-3 py-2">
                        @if ($waste->deleted_at)
                            <span class="text-darkWarning">Deshabilitado</span>
                        @else
                            <span class="text-darkSuccess">{{ $waste->status }}</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">{{ $waste->created_at->format('d/m/Y') }}</td>
                    <td class="px-3 py-2 flex justify-center gap-2">
                        @if ($waste->deleted_at)
                            <form action="{{ route('wastes.restore', $waste->id) }}" method="POST" class="restoreWasteForm">
                                @csrf
                                <button type="submit" class="text-darkPrimary" title="Restaurar">
                                    <i data-lucide="rotate-cw" class="icon-small"></i>
                                </button>
                            </form>
                            <form action="{{ route('wastes.forceDelete', $waste->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-darkDanger" title="Eliminar Permanentemente">
                                    <i data-lucide="trash-2" class="icon-small"></i>
                                </button>
                            </form>
                        @else
                            <button class="openEditModal text-darkPrimary" title="Editar"
                                    data-id="{{ $waste->id }}"
                                    data-user_id="{{ $waste->user_id }}"
                                    data-type_id="{{ $waste->type_id }}"
                                    data-description="{{ $waste->description }}"
                                    data-quantity="{{ $waste->quantity }}"
                                    data-status="{{ $waste->status }}"
                                    data-url="{{ route('wastes.update', $waste->id) }}">
                                <i data-lucide="edit" class="icon-small"></i>
                            </button>
                            <form action="{{ route('wastes.destroy', $waste->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-darkDanger" title="Eliminar">
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

    <div id="wasteModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-darkSurface p-6 rounded-lg shadow-lg w-1/3">
            <h2 id="modalTitle" class="text-xl font-semibold text-darkText"></h2>
            <form id="wasteForm" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod">

                <label class="block text-darkText">Usuario <span class="text-red-500">*</span>:</label>
                <select name="user_id" id="user_id" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>

                <label class="block text-darkText mt-4">Tipo de Residuo <span class="text-red-500">*</span>:</label>
                <select name="type_id" id="type_id" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                    @foreach ($wasteTypes as $wt)
                        <option value="{{ $wt->id }}">{{ $wt->name }}</option>
                    @endforeach
                </select>

                <label class="block text-darkText mt-4">Descripción <span class="text-red-500">*</span>:</label>
                <textarea name="description" id="description" class="w-full p-2 rounded bg-darkBackground text-darkText border" required></textarea>

                <label class="block text-darkText mt-4">Cantidad <span class="text-red-500">*</span>:</label>
                <input type="number" name="quantity" id="quantity" class="w-full p-2 rounded bg-darkBackground text-darkText border" min="1" required>

                <label class="block text-darkText mt-4">Estado <span class="text-red-500">*</span>:</label>
                <select name="status" id="status" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Recolectado">Recolectado</option>
                    <option value="Procesado">Procesado</option>
                    <option value="Eliminado">Eliminado</option>
                </select>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" id="closeModal" class="bg-gray-600 text-white px-4 py-2 rounded-md">Cancelar</button>
                    <button type="submit" class="bg-darkPrimary text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $("#wastesTable").DataTable({
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
                openModal("Crear Residuo", url, "POST", {});
            });

            $(document).on("click", ".openEditModal", function () {
                let data = {
                    user_id: $(this).data("user_id"),
                    type_id: $(this).data("type_id"),
                    description: $(this).data("description"),
                    quantity: $(this).data("quantity"),
                    status: $(this).data("status")
                };
                let url = $(this).data("url");
                openModal("Editar Residuo", url, "PUT", data);
            });

            function openModal(title, action, method, data) {
                $("#modalTitle").text(title);
                $("#wasteForm").attr("action", action);
                $("#formMethod").val(method);
                $("#user_id").val(data.user_id || "");
                $("#type_id").val(data.type_id || "");
                $("#description").val(data.description || "");
                $("#quantity").val(data.quantity || "");
                $("#status").val(data.status || "Pendiente");
                $("#wasteModal").removeClass("hidden");
            }

            $("#closeModal").on("click", function () {
                $("#wasteModal").addClass("hidden");
            });

            $("#wasteForm").validate({
                rules: {
                    user_id: { required: true },
                    type_id: { required: true },
                    description: { required: true, minlength: 3 },
                    quantity: { required: true, number: true, min: 1 },
                    status: { required: true }
                },
                messages: {
                    user_id: { required: "El usuario es obligatorio." },
                    type_id: { required: "El tipo de residuo es obligatorio." },
                    description: {
                        required: "La descripción es obligatoria.",
                        minlength: "La descripción debe tener al menos 3 caracteres."
                    },
                    quantity: {
                        required: "La cantidad es obligatoria.",
                        number: "Debe ser un número válido.",
                        min: "La cantidad debe ser al menos 1."
                    },
                    status: { required: "El estado es obligatorio." }
                }
            });
        });
    </script>
@endsection
