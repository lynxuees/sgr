<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Collection;
use App\Models\Waste;
use App\Models\WasteType;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $totalUsers = User::count();

        $collectedSolids = Waste::whereMonth('created_at', now()->month)
            ->where('state', 'Solido')
            ->sum('quantity');

        $collectedFluids = Waste::whereMonth('created_at', now()->month)
            ->whereIn('state', ['Liquido', 'Gaseoso'])
            ->sum('quantity');

        $totalCompletedCollections = Collection::where('status', 'Completado')->count();

        $processedSolids = Waste::where('status', 'Procesado')
            ->where('state', 'Solido')
            ->sum('quantity');

        $processedFluids = Waste::where('status', 'Procesado')
            ->whereIn('state', ['Liquido', 'Gaseoso'])
            ->sum('quantity');

        $latestCollections = Collection::with(['waste', 'collector'])
            ->latest()
            ->limit(5)
            ->get();

        $wasteCollectionCount = Collection::join('wastes', 'collections.waste_id', '=', 'wastes.id')
            ->join('waste_types', 'wastes.type_id', '=', 'waste_types.id')
            ->where('collections.status', 'Completado')
            ->select('waste_types.name', DB::raw('COUNT(collections.id) as total_collections'))
            ->groupBy('waste_types.id', 'waste_types.name')
            ->get();

        $classificationDataSolid = Waste::where('state', 'Solido')
            ->select('classification', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('classification')
            ->get();

        $originDataSolid = Waste::where('state', 'Solido')
            ->select('origin', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('origin')
            ->get();

        $classificationDataFluid = Waste::whereIn('state', ['Liquido', 'Gaseoso'])
            ->select('classification', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('classification')
            ->get();

        $originDataFluid = Waste::whereIn('state', ['Liquido', 'Gaseoso'])
            ->select('origin', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('origin')
            ->get();

        return view('dashboard.index', compact(
            'totalUsers',
            'collectedSolids',
            'collectedFluids',
            'totalCompletedCollections',
            'processedSolids',
            'processedFluids',
            'latestCollections',
            'wasteCollectionCount',
            'classificationDataSolid',
            'originDataSolid',
            'classificationDataFluid',
            'originDataFluid'
        ));
    }
}
