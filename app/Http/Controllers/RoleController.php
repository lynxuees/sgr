<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::withTrashed()->get();
        return view('roles.index', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        Role::create($validated);

        return Redirect::route('roles.index')->with('success', 'Rol creado correctamente.');
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update($validated);

        return Redirect::route('roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return Redirect::route('roles.index')->with('success', 'Rol deshabilitado correctamente.');
    }

    public function restore($id): RedirectResponse
    {
        Role::withTrashed()->findOrFail($id)->restore();
        return Redirect::route('roles.index')->with('success', 'Rol restaurado correctamente.');
    }

    public function forceDelete($id): RedirectResponse
    {
        Role::withTrashed()->findOrFail($id)->forceDelete();
        return Redirect::route('roles.index')->with('success', 'Rol eliminado permanentemente.');
    }
}
