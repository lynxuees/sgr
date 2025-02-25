<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WasteTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wasteTypes = [
            ['name' => 'Orgánico'],
            ['name' => 'Plástico'],
            ['name' => 'Vidrio'],
            ['name' => 'Metal'],
            ['name' => 'Papel y Cartón'],
            ['name' => 'Residuos Peligrosos'],
            ['name' => 'Residuos Electrónicos'],
            ['name' => 'Textiles'],
        ];

        foreach ($wasteTypes as $type) {
            DB::table('waste_types')->updateOrInsert(
                ['name' => $type['name']],
                [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
