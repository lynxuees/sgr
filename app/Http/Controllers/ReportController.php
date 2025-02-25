<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function downloadCollectionsReport(): BinaryFileResponse
    {
        $collections = Collection::with(['waste', 'collector', 'disposal'])->get()->map(function($collection) {
            return [
                'ID'              => $collection->id,
                'Residuo'         => $collection->waste ? $collection->waste->description : 'N/A',
                'Recolector'      => $collection->collector ? $collection->collector->name : 'N/A',
                'Centro'          => $collection->disposal ? $collection->disposal->name : 'N/A',
                'Cantidad'        => $collection->quantity,
                'Unidad'          => $collection->unit,
                'Tipo'            => $collection->type,
                'Clasificación'   => $collection->classification,
                'Estado'          => $collection->state,
                'Origen'          => $collection->origin,
                'Frecuencia'      => $collection->frequency,
                'Horario'         => $collection->schedule,
                'Status'          => $collection->status,
                'Fecha'           => Carbon::parse($collection->date)->format('d/m/Y'),
                'Localización'    => $collection->location,
                'Creación'        => $collection->created_at->format('d/m/Y'),
            ];
        });

        $export = new class($collections) implements
            FromCollection,
            WithHeadings
        {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'ID',
                    'Residuo',
                    'Recolector',
                    'Centro',
                    'Cantidad',
                    'Unidad',
                    'Tipo',
                    'Clasificación',
                    'Estado',
                    'Origen',
                    'Frecuencia',
                    'Horario',
                    'Status',
                    'Fecha',
                    'Localización',
                    'Creación',
                ];
            }
        };

        return Excel::download($export, 'collections_report.xlsx');
    }
}
