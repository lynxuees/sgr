<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disposal;

class DisposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Disposal::factory()->count(10)->create();
    }
}
