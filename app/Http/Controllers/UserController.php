<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::withTrashed()->get();
        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return Redirect::route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return Redirect::route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return Redirect::route('users.index')->with('success', 'Usuario deshabilitado correctamente.');
    }

    public function restore($id): RedirectResponse
    {
        User::withTrashed()->findOrFail($id)->restore();
        return Redirect::route('users.index')->with('success', 'Usuario restaurado correctamente.');
    }

    public function forceDelete($id): RedirectResponse
    {
        User::withTrashed()->findOrFail($id)->forceDelete();
        return Redirect::route('users.index')->with('success', 'Usuario eliminado permanentemente.');
    }
}
