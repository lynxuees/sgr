<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('es_ES');

        $firstName = $faker->firstName();
        $lastName = $faker->lastName();
        $email = strtolower($this->removeAccents($firstName) . '.' . $this->removeAccents($lastName)) . '@sgr.test';

        return [
            'name' => "$firstName $lastName",
            'email' => $email,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role_id' => Role::inRandomOrder()->first()->id,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function removeAccents(string $string): string
    {
        $unwanted = [
            'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U',
            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u',
            'Ñ'=>'N', 'ñ'=>'n'
        ];

        return strtr($string, $unwanted);
    }
}
