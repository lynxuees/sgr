<?php

namespace Database\Factories;

use App\Models\Disposal;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisposalFactory extends Factory
{
    protected $model = Disposal::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'contact' => $this->faker->name,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'capacity' => $this->faker->numberBetween(100, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
