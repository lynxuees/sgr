@extends('layouts.app')

@section('title', 'Gestión de Roles')

@section('page-title', 'Administración de Roles')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Lista de Roles</h2>
        <div class="mt-4 flex justify-end">
            <button id="openCreateModal" class="bg-darkPrimary text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i data-lucide="plus"></i> Agregar Rol
            </button>
        </div>
        <table id="rolesTable" class="datatable w-full text-left bg-darkSurface border-collapse">
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
            @foreach ($roles as $role)
                <tr class="border-b border-gray-700">
                    <td class="px-3 py-2">{{ $role->id }}</td>
                    <td class="px-3 py-2">{{ $role->name }}</td>
                    <td class="px-3 py-2">{{ $role->created_at->format('d/m/Y') }}</td>
                    <td class="px-3 py-2">
                        @if ($role->deleted_at)
                            <span class="text-darkWarning">Deshabilitado</span>
                        @else
                            <span class="text-darkSuccess">Activo</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 flex justify-center gap-2">
                        @if ($role->deleted_at)
                            <a href="{{ route('roles.restore', $role->id) }}" class="text-darkPrimary" title="Restaurar">
                                <i data-lucide="rotate-cw" class="icon-small"></i>
                            </a>
                            <form action="{{ route('roles.forceDelete', $role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-darkDanger" title="Eliminar Permanentemente">
                                    <i data-lucide="trash-2" class="icon-small"></i>
                                </button>
                            </form>
                        @else
                            <button class="openEditModal text-darkPrimary" title="Editar"
                                    data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                <i data-lucide="edit" class="icon-small"></i>
                            </button>
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
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

    <div id="roleModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-darkSurface p-6 rounded-lg shadow-lg w-1/3">
            <h2 id="modalTitle" class="text-xl font-semibold text-darkText"></h2>
            <form id="roleForm" method="POST" class="mt-4">
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
            if (typeof $ === "undefined") {
                console.error("jQuery is not available.");
                return;
            }

            $("#rolesTable").DataTable({
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros en total)",
                    zeroRecords: "No se encontraron registros",
                    emptyTable: "No hay datos disponibles en la tabla"
                }
            });

            $("#openCreateModal").on("click", function () {
                openModal("Crear Rol", "{{ route('roles.store') }}", "POST");
            });

            $(document).on("click", ".openEditModal", function () {
                openModal("Editar Rol", "{{ route('roles.update', '') }}/" + $(this).data("id"), "PUT", {
                    name: $(this).data("name")
                });
            });

            function openModal(title, action, method, data = {}) {
                $("#modalTitle").text(title);
                $("#roleForm").attr("action", action);
                $("#formMethod").val(method);
                $("#name").val(data.name || "");
                $("#roleModal").removeClass("hidden");
            }

            $("#closeModal").on("click", function () {
                $("#roleModal").addClass("hidden");
            });

            $("#roleForm").validate({
                rules: {
                    name: { required: true, minlength: 3, maxlength: 255 }
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
