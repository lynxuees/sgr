<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use App\Models\User;
use App\Models\WasteType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WasteController extends Controller
{
    public function index(): View
    {
        $wastes = Waste::withTrashed()->with(['user', 'type'])->get();
        $users = User::all();
        $wasteTypes = WasteType::all();
        return view('wastes.index', compact('wastes', 'users', 'wasteTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'type_id'     => 'required|exists:waste_types,id',
            'description' => 'required|string|min:3',
            'quantity'    => 'required|integer|min:1',
            'status'      => 'required|in:Pendiente,Recolectado,Procesado,Eliminado',
        ]);

        Waste::create($validated);

        return Redirect::route('wastes.index')->with('success', 'Residuo creado correctamente.');
    }

    public function update(Request $request, Waste $waste): RedirectResponse
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'type_id'     => 'required|exists:waste_types,id',
            'description' => 'required|string|min:3',
            'quantity'    => 'required|integer|min:1',
            'status'      => 'required|in:Pendiente,Recolectado,Procesado,Eliminado',
        ]);

        $waste->update($validated);

        return Redirect::route('wastes.index')->with('success', 'Residuo actualizado correctamente.');
    }

    public function destroy(Waste $waste): RedirectResponse
    {
        $waste->delete();
        return Redirect::route('wastes.index')->with('success', 'Residuo deshabilitado correctamente.');
    }

    public function restore($waste): RedirectResponse
    {
        $waste = Waste::withTrashed()->findOrFail($waste);
        $waste->restore();
        return Redirect::route('wastes.index')->with('success', 'Residuo restaurado correctamente.');
    }

    public function forceDelete($waste): RedirectResponse
    {
        $waste = Waste::withTrashed()->findOrFail($waste);
        $waste->forceDelete();
        return Redirect::route('wastes.index')->with('success', 'Residuo eliminado permanentemente.');
    }

}
