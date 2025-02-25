@extends('layouts.app')

@section('title', 'Gestión de Centros de Disposición')
@section('page-title', 'Administración de Centros de Disposición')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Centros de Reciclaje</h2>
        <div class="mt-4 flex justify-end">
            <button id="openCreateModal"
                    data-url="{{ route('disposals.store') }}"
                    class="bg-darkPrimary text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i data-lucide="plus" class="icon-small"></i> Agregar Centro
            </button>
        </div>
        <table id="disposalsTable" class="datatable w-full text-left bg-darkSurface border-collapse">
            <thead>
            <tr>
                <th class="px-3 py-2 border-b">ID</th>
                <th class="px-3 py-2 border-b">Nombre</th>
                <th class="px-3 py-2 border-b">Teléfono</th>
                <th class="px-3 py-2 border-b">Email</th>
                <th class="px-3 py-2 border-b">Contacto</th>
                <th class="px-3 py-2 border-b">Ciudad</th>
                <th class="px-3 py-2 border-b">Dirección</th>
                <th class="px-3 py-2 border-b">Capacidad</th>
                <th class="px-3 py-2 border-b">Estado</th>
                <th class="px-3 py-2 border-b">Creación</th>
                <th class="px-3 py-2 border-b text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($disposals as $disposal)
                <tr class="border-b border-gray-700">
                    <td class="px-3 py-2">{{ $disposal->id }}</td>
                    <td class="px-3 py-2">{{ $disposal->name }}</td>
                    <td class="px-3 py-2">{{ $disposal->phone }}</td>
                    <td class="px-3 py-2">{{ $disposal->email }}</td>
                    <td class="px-3 py-2">{{ $disposal->contact }}</td>
                    <td class="px-3 py-2">{{ $disposal->city }}</td>
                    <td class="px-3 py-2">{{ $disposal->address }}</td>
                    <td class="px-3 py-2">{{ $disposal->capacity }}</td>
                    <td class="px-3 py-2">
                        @if ($disposal->deleted_at)
                            <span class="text-darkWarning">Deshabilitado</span>
                        @else
                            <span class="text-darkSuccess">Activo</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">{{ $disposal->created_at->format('d/m/Y') }}</td>
                    <td class="px-3 py-2 flex justify-center gap-2">
                        @if ($disposal->deleted_at)
                            <form action="{{ route('disposals.restore', $disposal->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="text-darkPrimary" title="Restaurar">
                                    <i data-lucide="rotate-cw" class="icon-small"></i>
                                </button>
                            </form>
                            <form action="{{ route('disposals.forceDelete', $disposal->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-darkDanger" title="Eliminar Permanentemente">
                                    <i data-lucide="trash-2" class="icon-small"></i>
                                </button>
                            </form>
                        @else
                            <button class="openEditModal text-darkPrimary" title="Editar"
                                    data-id="{{ $disposal->id }}"
                                    data-name="{{ $disposal->name }}"
                                    data-phone="{{ $disposal->phone }}"
                                    data-email="{{ $disposal->email }}"
                                    data-contact="{{ $disposal->contact }}"
                                    data-city="{{ $disposal->city }}"
                                    data-address="{{ $disposal->address }}"
                                    data-capacity="{{ $disposal->capacity }}"
                                    data-url="{{ route('disposals.update', $disposal->id) }}">
                                <i data-lucide="edit" class="icon-small"></i>
                            </button>
                            <form action="{{ route('disposals.destroy', $disposal->id) }}" method="POST" style="display: inline;">
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

    <div id="disposalModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-darkSurface p-6 rounded-lg shadow-lg w-1/3">
            <h2 id="modalTitle" class="text-xl font-semibold text-darkText"></h2>
            <form id="disposalForm" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod">

                <label class="block text-darkText">Nombre <span class="text-red-500">*</span>:</label>
                <input type="text" name="name" id="name" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Teléfono <span class="text-red-500">*</span>:</label>
                <input type="text" name="phone" id="phone" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Email <span class="text-red-500">*</span>:</label>
                <input type="email" name="email" id="email" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Contacto <span class="text-red-500">*</span>:</label>
                <input type="text" name="contact" id="contact" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Ciudad <span class="text-red-500">*</span>:</label>
                <input type="text" name="city" id="city" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Dirección <span class="text-red-500">*</span>:</label>
                <input type="text" name="address" id="address" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Capacidad <span class="text-red-500">*</span>:</label>
                <input type="number" name="capacity" id="capacity" class="w-full p-2 rounded bg-darkBackground text-darkText border" min="1" required>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" id="closeModal" class="bg-gray-600 text-white px-4 py-2 rounded-md">Cancelar</button>
                    <button type="submit" class="bg-darkPrimary text-white px-4 py-2 rounded-md">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $("#disposalsTable").DataTable({
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
                openModal("Crear Centro", url, "POST", {});
            });

            $(document).on("click", ".openEditModal", function () {
                let url = $(this).data("url");
                let data = {
                    name: $(this).data("name"),
                    phone: $(this).data("phone"),
                    email: $(this).data("email"),
                    contact: $(this).data("contact"),
                    city: $(this).data("city"),
                    address: $(this).data("address"),
                    capacity: $(this).data("capacity")
                };
                openModal("Editar Centro", url, "PUT", data);
            });

            function openModal(title, action, method, data) {
                $("#modalTitle").text(title);
                $("#disposalForm").attr("action", action);
                $("#formMethod").val(method);

                $("#name").val(data.name || "");
                $("#phone").val(data.phone || "");
                $("#email").val(data.email || "");
                $("#contact").val(data.contact || "");
                $("#city").val(data.city || "");
                $("#address").val(data.address || "");
                $("#capacity").val(data.capacity || 1);

                $("#disposalModal").removeClass("hidden");
            }

            $("#closeModal").on("click", function () {
                $("#disposalModal").addClass("hidden");
            });

            $("#disposalForm").validate({
                rules: {
                    name: { required: true, minlength: 3, maxlength: 255 },
                    phone: { required: true, minlength: 3, maxlength: 255 },
                    email: { required: true, email: true, maxlength: 255 },
                    contact: { required: true, minlength: 3, maxlength: 255 },
                    city: { required: true, minlength: 3, maxlength: 255 },
                    address: { required: true, minlength: 3, maxlength: 255 },
                    capacity: { required: true, number: true, min: 1 }
                },
                messages: {
                    name: {
                        required: "El nombre es obligatorio.",
                        minlength: "Debe tener al menos 3 caracteres.",
                        maxlength: "No puede superar los 255 caracteres."
                    },
                    phone: {
                        required: "El teléfono es obligatorio.",
                        minlength: "Debe tener al menos 3 caracteres.",
                        maxlength: "No puede superar los 255 caracteres."
                    },
                    email: {
                        required: "El email es obligatorio.",
                        email: "Debe ingresar un email válido.",
                        maxlength: "No puede superar los 255 caracteres."
                    },
                    contact: {
                        required: "El contacto es obligatorio.",
                        minlength: "Debe tener al menos 3 caracteres.",
                        maxlength: "No puede superar los 255 caracteres."
                    },
                    city: {
                        required: "La ciudad es obligatoria.",
                        minlength: "Debe tener al menos 3 caracteres.",
                        maxlength: "No puede superar los 255 caracteres."
                    },
                    address: {
                        required: "La dirección es obligatoria.",
                        minlength: "Debe tener al menos 3 caracteres.",
                        maxlength: "No puede superar los 255 caracteres."
                    },
                    capacity: {
                        required: "La capacidad es obligatoria.",
                        number: "Debe ser un número válido.",
                        min: "La capacidad debe ser al menos 1."
                    }
                }
            });
        });
    </script>
@endsection
