<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class WastesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $units = ['T', 'Kg', 'L', 'm³'];
        $classifications = ['Ordinario', 'Reciclable', 'Peligroso'];
        $states = ['Sólido', 'Líquido', 'Gaseoso'];
        $origins = ['Industrial', 'Comercial', 'Residencial'];
        $types = ['Generado', 'Reciclado', 'Eliminado'];
        $statuses = ['Pendiente', 'Recolectado', 'Procesado', 'Eliminado'];

        $wastes = [];

        for ($i = 1; $i <= 50; $i++) {
            $wastes[] = [
                'user_id'     => $faker->numberBetween(1, 10),
                'type_id'     => $faker->numberBetween(1, 8),
                'description' => $faker->randomElement([
                    'Residuos Orgánicos', 'Envases Plásticos', 'Vidrio Roto', 'Papel y Cartón',
                    'Residuos Electrónicos', 'Metales', 'Residuos Peligrosos', 'Textiles'
                ]),

                'quantity'    => $faker->numberBetween(1, 100),
                'unit'        => $faker->randomElement($units),
                'classification' => $faker->randomElement($classifications),
                'state'       => $faker->randomElement($states),
                'origin'      => $faker->randomElement($origins),
                'type'        => $faker->randomElement($types),
                'status'      => $faker->randomElement($statuses),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
        }

        DB::table('wastes')->insert($wastes);
    }
}
