<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Collection::factory()->count(50)->create();
    }
}
