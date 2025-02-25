<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Waste;
use App\Models\User;
use App\Models\Disposal;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CollectionController extends Controller
{
    public function index(): View
    {
        // Cargamos las colecciones (incluyendo soft-deleted) junto con sus relaciones.
        $collections = Collection::withTrashed()->with(['waste', 'collector', 'disposal'])->get();
        // Datos para el formulario de creación/edición
        $wastes = Waste::all();
        $collectors = User::all();
        $disposals = Disposal::all();
        return view('collections.index', compact('collections', 'wastes', 'collectors', 'disposals'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'waste_id'       => 'required|exists:wastes,id',
            'collector_id'   => 'required|exists:users,id',
            'disposal_id'    => 'required|exists:disposals,id',
            'quantity'       => 'required|integer|min:1',
            'unit'           => 'required|in:T,Kg,L,m³',
            'type'           => 'required|in:Generado,Reciclado,Eliminado',
            'classification' => 'required|in:Ordinario,Reciclable,Peligroso',
            'state'          => 'required|in:Sólido,Líquido,Gaseoso',
            'origin'         => 'required|in:Industrial,Comercial,Residencial',
            'frequency'      => 'required|in:Diario,Semanal,Mensual',
            'schedule'       => 'required|in:Mañana,Tarde,Noche',
            'status'         => 'required|in:Programado,En camino,Completado',
            'date'           => 'required|date',
            'location'       => 'required|string|min:3|max:255',
        ]);

        Collection::create($validated);

        return Redirect::route('collections.index')->with('success', 'Colección creada correctamente.');
    }

    public function update(Request $request, Collection $collection): RedirectResponse
    {
        $validated = $request->validate([
            'waste_id'       => 'required|exists:wastes,id',
            'collector_id'   => 'required|exists:users,id',
            'disposal_id'    => 'required|exists:disposals,id',
            'quantity'       => 'required|integer|min:1',
            'unit'           => 'required|in:T,Kg,L,m³',
            'type'           => 'required|in:Generado,Reciclado,Eliminado',
            'classification' => 'required|in:Ordinario,Reciclable,Peligroso',
            'state'          => 'required|in:Sólido,Líquido,Gaseoso',
            'origin'         => 'required|in:Industrial,Comercial,Residencial',
            'frequency'      => 'required|in:Diario,Semanal,Mensual',
            'schedule'       => 'required|in:Mañana,Tarde,Noche',
            'status'         => 'required|in:Programado,En camino,Completado',
            'date'           => 'required|date',
            'location'       => 'required|string|min:3|max:255',
        ]);

        $collection->update($validated);

        return Redirect::route('collections.index')->with('success', 'Colección actualizada correctamente.');
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        $collection->delete();
        return Redirect::route('collections.index')->with('success', 'Colección deshabilitada correctamente.');
    }

    public function restore($collection): RedirectResponse
    {
        $collection = Collection::withTrashed()->findOrFail($collection);
        $collection->restore();
        return Redirect::route('collections.index')->with('success', 'Colección restaurada correctamente.');
    }

    public function forceDelete($collection): RedirectResponse
    {
        $collection = Collection::withTrashed()->findOrFail($collection);
        $collection->forceDelete();
        return Redirect::route('collections.index')->with('success', 'Colección eliminada permanentemente.');
    }
}
