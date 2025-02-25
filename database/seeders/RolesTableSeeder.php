<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'center_manager'],
            ['name' => 'collector'],
            ['name' => 'driver'],
            ['name' => 'viewer'],
            ['name' => 'customer'],
        ];

        DB::table('roles')->insert($roles);
    }
}
