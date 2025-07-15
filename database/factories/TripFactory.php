<?php

namespace Database\Factories;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        $cities = [
            'São Paulo',
            'Rio de Janeiro',
            'Belo Horizonte',
            'Salvador',
            'Brasília',
            'Fortaleza',
            'Recife',
            'Porto Alegre',
            'Manaus',
            'Curitiba',
            'Goiânia',
            'Belém',
            'Guarulhos',
            'Campinas',
            'São Luís',
            'Maceió',
            'Natal',
            'João Pessoa',
            'Aracaju',
            'Teresina',
            'Campo Grande',
            'Cuiabá',
            'Florianópolis'
        ];

        $origin = $faker->randomElement($cities);
        $destination = $faker->randomElement(array_diff($cities, [$origin]));

        $route = "{$origin} → {$destination}";
        $name = "Viagem {$origin} - {$destination}";

        $departureDate = $faker->dateTimeBetween('-1 week', '+2 months');
        $departureTime = $faker->time('H:i');

        $status = 'in_progress';
        if ($departureDate < Carbon::now()) {
            $status = $faker->randomElement(['completed', 'cancelled']);
        }

        return [
            'name' => $name,
            'status' => $status,
            'departure_date' => $departureDate->format('Y-m-d'),
            'departure_time' => $departureTime,
            'origin' => $origin,
            'destination' => $destination,
            'route' => $route,
            'rules' => $faker->randomElement(['Turismo', 'Fretamento', 'Linha Regular']),
            'passenger_price' => $faker->randomFloat(2, 25.00, 200.00),
            'max_passengers' => $faker->numberBetween(20, 50),
            'vehicle_id' => Vehicle::factory(),
            'driver_id' => Driver::factory(),
        ];
    }
}
