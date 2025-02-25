@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('page-title', 'Administración de Usuarios')

@section('content')
    <div class="bg-darkBackground p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-darkText">Lista de Usuarios</h2>
        <div class="mt-4 flex justify-end">
            <button id="openCreateModal" class="bg-darkPrimary text-white px-4 py-2 rounded-md flex items-center gap-2">
                <i data-lucide="plus"></i> Agregar Usuario
            </button>
        </div>
        <table id="usersTable" class="datatable w-full text-left bg-darkSurface border-collapse">
            <thead>
            <tr>
                <th class="px-3 py-2 border-b">ID</th>
                <th class="px-3 py-2 border-b">Nombre</th>
                <th class="px-3 py-2 border-b">Email</th>
                <th class="px-3 py-2 border-b">Rol</th>
                <th class="px-3 py-2 border-b">Fecha de Creación</th>
                <th class="px-3 py-2 border-b">Estado</th>
                <th class="px-3 py-2 border-b text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="border-b border-gray-700">
                    <td class="px-3 py-2">{{ $user->id }}</td>
                    <td class="px-3 py-2">{{ $user->name }}</td>
                    <td class="px-3 py-2">{{ $user->email }}</td>
                    <td class="px-3 py-2">{{ $user->role->name }}</td>
                    <td class="px-3 py-2">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-3 py-2">
                        @if ($user->deleted_at)
                            <span class="text-darkWarning">Deshabilitado</span>
                        @else
                            <span class="text-darkSuccess">Activo</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 flex justify-center gap-2">
                        @if ($user->deleted_at)
                            <a href="{{ route('users.restore', $user->id) }}" class="text-darkPrimary" title="Restaurar">
                                <i data-lucide="rotate-cw" class="icon-small"></i>
                            </a>
                            <form action="{{ route('users.forceDelete', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-darkDanger" title="Eliminar Permanentemente">
                                    <i data-lucide="trash-2" class="icon-small"></i>
                                </button>
                            </form>
                        @else
                            <button class="openEditModal text-darkPrimary" title="Editar"
                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                    data-email="{{ $user->email }}" data-role="{{ $user->role_id }}">
                                <i data-lucide="edit" class="icon-small"></i>
                            </button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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

    <!-- Modal de Crear/Editar Usuario -->
    <div id="userModal" class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-darkSurface p-6 rounded-lg shadow-lg w-1/3">
            <h2 id="modalTitle" class="text-xl font-semibold text-darkText"></h2>
            <form id="userForm" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="_method" id="formMethod">

                <label class="block text-darkText">Nombre <span class="text-red-500">*</span>:</label>
                <input type="text" name="name" id="name" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Email <span class="text-red-500">*</span>:</label>
                <input type="email" name="email" id="email" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>

                <label class="block text-darkText mt-4">Rol <span class="text-red-500">*</span>:</label>
                <select name="role_id" id="role" class="w-full p-2 rounded bg-darkBackground text-darkText border" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>

                <div id="passwordToggleContainer" class="mt-4 hidden">
                    <input type="checkbox" id="togglePasswordChange">
                    <label for="togglePasswordChange" class="text-darkText">Cambiar Contraseña</label>
                </div>

                <div id="passwordSection">
                    <label class="block text-darkText mt-4">Contraseña <span class="text-red-500">*</span>:</label>
                    <input type="password" name="password" id="password" class="w-full p-2 rounded bg-darkBackground text-darkText border">
                    <label class="block text-darkText mt-4">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 rounded bg-darkBackground text-darkText border">
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
            if (typeof $ === "undefined") {
                console.error("jQuery is not available.");
                return;
            }

            $("#openCreateModal").on("click", function () {
                openModal("Crear Usuario", "{{ route('users.store') }}", "POST", true);
            });

            $(document).on("click", ".openEditModal", function () {
                openModal("Editar Usuario", "{{ route('users.update', '') }}/" + $(this).data("id"), "PUT", false, {
                    name: $(this).data("name"),
                    email: $(this).data("email"),
                    role: $(this).data("role")
                });
            });

            function openModal(title, action, method, showPassword, data = {}) {
                $("#modalTitle").text(title);
                $("#userForm").attr("action", action);
                $("#formMethod").val(method);
                $("#name").val(data.name || "");
                $("#email").val(data.email || "");
                $("#role").val(data.role || "");
                $("#passwordToggleContainer").toggleClass("hidden", method === "POST");

                if (method === "PUT") {
                    $("#passwordSection").addClass("hidden");
                    $("#togglePasswordChange").prop("checked", false);
                } else {
                    $("#passwordSection").removeClass("hidden");
                }

                $("#userModal").removeClass("hidden");
            }

            $("#closeModal").on("click", function () {
                $("#userModal").addClass("hidden");
            });

            $("#togglePasswordChange").on("change", function () {
                $("#passwordSection").toggleClass("hidden", !this.checked);
            });

            $("#userForm").validate({
                rules: {
                    name: { required: true, minlength: 3 },
                    email: { required: true, email: true },
                    password: {
                        required: function () {
                            return $("#modalTitle").text() === "Crear Usuario";
                        },
                        minlength: 8
                    },
                    password_confirmation: { equalTo: "#password" }
                }
            });
        });
    </script>

@endsection
