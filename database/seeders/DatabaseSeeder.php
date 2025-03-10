<?php

namespace Database\Seeders;

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
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]);
        }

        User::factory(20)->create();

        $this->call([
            WasteTypesSeeder::class,
            WastesSeeder::class,
            DisposalSeeder::class,
            CollectionSeeder::class,
        ]);

    }
}
