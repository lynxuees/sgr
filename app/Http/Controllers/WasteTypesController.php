<?php

namespace App\Http\Controllers;

use App\Models\WasteType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WasteTypesController extends Controller
{
    public function index(): View
    {
        $wasteTypes = WasteType::withTrashed()->get();
        return view('waste_types.index', compact('wasteTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:waste_types',
        ]);

        WasteType::create($validated);

        return Redirect::route('waste_types.index')->with('success', 'Tipo de residuo creado correctamente.');
    }

    public function update(Request $request, WasteType $wasteType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:waste_types,name,' . $wasteType->id,
        ]);

        $wasteType->update($validated);

        return Redirect::route('waste_types.index')->with('success', 'Tipo de residuo actualizado correctamente.');
    }

    public function destroy(WasteType $wasteType): RedirectResponse
    {
        $wasteType->delete();
        return Redirect::route('waste_types.index')->with('success', 'Tipo de residuo deshabilitado correctamente.');
    }

    public function restore($wasteType): RedirectResponse
    {
        WasteType::withTrashed()->findOrFail($wasteType)->restore();
        return Redirect::route('waste_types.index')->with('success', 'Tipo de residuo restaurado correctamente.');
    }

    public function forceDelete($wasteType): RedirectResponse
    {
        WasteType::withTrashed()->findOrFail($wasteType)->forceDelete();
        return Redirect::route('waste_types.index')->with('success', 'Tipo de residuo eliminado permanentemente.');
    }
}
