<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\Waste;
use App\Models\User;
use App\Models\Disposal;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition()
    {
        return [
            'waste_id' => $this->faker->numberBetween(1, 4),
            'collector_id' => $this->faker->numberBetween(1, 10),
            'disposal_id' => $this->faker->numberBetween(1, 10),
            'quantity' => $this->faker->numberBetween(1, 1000),
            'unit' => $this->faker->randomElement(['T', 'Kg', 'L', 'm³']),
            'type' => $this->faker->randomElement(['Generado', 'Reciclado', 'Eliminado']),
            'classification' => $this->faker->randomElement(['Ordinario', 'Reciclable', 'Peligroso']),
            'state' => $this->faker->randomElement(['Sólido', 'Líquido', 'Gaseoso']),
            'origin' => $this->faker->randomElement(['Industrial', 'Comercial', 'Residencial']),
            'frequency' => $this->faker->randomElement(['Diario', 'Semanal', 'Mensual']),
            'schedule' => $this->faker->randomElement(['Mañana', 'Tarde', 'Noche']),
            'status' => $this->faker->randomElement(['Programado', 'En camino', 'Completado']),
            'date' => $this->faker->date(),
            'location' => $this->faker->address,
        ];
    }
}
