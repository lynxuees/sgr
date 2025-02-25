<?php

namespace App\Http\Controllers;

use App\Models\Disposal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DisposalController extends Controller
{
    public function index(): View
    {
        $disposals = Disposal::withTrashed()->get();
        return view('disposals.index', compact('disposals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'contact'  => 'required|string|max:255',
            'city'     => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Disposal::create($validated);

        return Redirect::route('disposals.index')->with('success', 'Centro de disposición creado correctamente.');
    }

    public function update(Request $request, Disposal $disposal): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'contact'  => 'required|string|max:255',
            'city'     => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $disposal->update($validated);

        return Redirect::route('disposals.index')->with('success', 'Centro de disposición actualizado correctamente.');
    }

    public function destroy(Disposal $disposal): RedirectResponse
    {
        $disposal->delete();
        return Redirect::route('disposals.index')->with('success', 'Centro de disposición deshabilitado correctamente.');
    }

    public function restore($disposal): RedirectResponse
    {
        $disposal = Disposal::withTrashed()->findOrFail($disposal);
        $disposal->restore();
        return Redirect::route('disposals.index')->with('success', 'Centro de disposición restaurado correctamente.');
    }

    public function forceDelete($disposal): RedirectResponse
    {
        $disposal = Disposal::withTrashed()->findOrFail($disposal);
        $disposal->forceDelete();
        return Redirect::route('disposals.index')->with('success', 'Centro de disposición eliminado permanentemente.');
    }
}
