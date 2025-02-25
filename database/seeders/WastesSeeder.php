<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WastesSeeder extends Seeder
{
    public function run(): void
    {
        $wastes = [
            [
                'user_id'     => 1,
                'type_id'     => 1,
                'description' => 'Residuo orgánico de cocina',
                'quantity'    => 10,
                'status'      => 'Pendiente',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'user_id'     => 2,
                'type_id'     => 2,
                'description' => 'Envases plásticos usados',
                'quantity'    => 20,
                'status'      => 'Recolectado',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'user_id'     => 3,
                'type_id'     => 3,
                'description' => 'Botellas de vidrio rotas',
                'quantity'    => 15,
                'status'      => 'Procesado',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'user_id'     => 1,
                'type_id'     => 4,
                'description' => 'Chatarra metálica',
                'quantity'    => 5,
                'status'      => 'Eliminado',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ];

        DB::table('wastes')->insert($wastes);
    }
}
