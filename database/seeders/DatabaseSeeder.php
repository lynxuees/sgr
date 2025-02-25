<?php

namespace Database\Seeders;

use App\Models\Disposal;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
        ]);

        if (!User::where('email', 'admin@sgr.test')->exists()) {
            User::create([
                'name' => 'Admin SGR',
                'email' => 'admin@sgr.test',
                'email_verified_at' => now(),
                'password' => Hash::make('adminsgr'),
                'role_id' => 1,
            ]);
        }
        User::factory(20)->create();
        Disposal::factory()->count(10)->create();
    }
}
