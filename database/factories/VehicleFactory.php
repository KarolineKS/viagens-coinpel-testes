<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        $models = [
            'Comil Campione DD',
            'Marcopolo G7 1050',
            'Busscar Vissta Buss LO',
            'Irizar i6',
            'Mercedes-Benz OF-1722',
            'Volvo B290R',
            'Scania K124',
            'Comil Svelto',
            'Marcopolo Paradiso 1200',
            'Busscar El Buss 340'
        ];

        $vehicleTypes = [
            'Ônibus Executivo',
            'Ônibus Convencional',
            'Micro-ônibus',
            'Van',
            'Ônibus Leito'
        ];

        $seatingLayouts = [
            'Semi-Leito',
            'Leito',
            'Convencional',
        ];

        $capacity = $faker->numberBetween(20, 50);
        $prefix = strtoupper($faker->lexify('??'));
        $number = $faker->numberBetween(100, 999);

        return [
            'identification_name' => $prefix . ' ' . $number,
            'prefix' => $prefix,
            'license_plate' => $faker->bothify('???#?##'),
            'model' => $faker->randomElement($models),
            'chassis' => strtoupper($faker->bothify('??########')),
            'vehicle_type' => $faker->randomElement($vehicleTypes),
            'capacity' => $capacity,
            'year' => $faker->numberBetween(2015, 2024),
            'seating_layout' => $faker->randomElement($seatingLayouts),
            'has_internet' => $faker->boolean(70),
            'has_wc' => $faker->boolean(60),
            'has_power_outlet' => $faker->boolean(80),
            'has_ac' => $faker->boolean(95),
            'has_fridge' => $faker->boolean(40),
            'has_heating' => $faker->boolean(30),
            'has_video' => $faker->boolean(50),
        ];
    }

    /**
     * Indicate that the vehicle is a luxury bus.
     */
    public function luxury(): static
    {
        return $this->state(fn(array $attributes) => [
            'vehicle_type' => 'Ônibus Executivo',
            'seating_layout' => 'Semi-Leito',
            'capacity' => $this->faker->numberBetween(30, 40),
            'has_internet' => true,
            'has_wc' => true,
            'has_power_outlet' => true,
            'has_ac' => true,
            'has_fridge' => true,
            'has_heating' => true,
            'has_video' => true,
        ]);
    }

    /**
     * Indicate that the vehicle is a basic bus.
     */
    public function basic(): static
    {
        return $this->state(fn(array $attributes) => [
            'vehicle_type' => 'Ônibus Convencional',
            'seating_layout' => 'Leito',
            'capacity' => $this->faker->numberBetween(40, 50),
            'has_internet' => false,
            'has_wc' => false,
            'has_power_outlet' => false,
            'has_ac' => $this->faker->boolean(70),
            'has_fridge' => false,
            'has_heating' => false,
            'has_video' => false,
        ]);
    }

    /**
     * Indicate that the vehicle is a micro-bus.
     */
    public function microBus(): static
    {
        return $this->state(fn(array $attributes) => [
            'vehicle_type' => 'Micro-ônibus',
            'seating_layout' => 'Convencional',
            'capacity' => $this->faker->numberBetween(15, 25),
            'has_internet' => $this->faker->boolean(50),
            'has_wc' => false,
            'has_power_outlet' => $this->faker->boolean(60),
            'has_ac' => $this->faker->boolean(80),
            'has_fridge' => false,
            'has_heating' => false,
            'has_video' => $this->faker->boolean(30),
        ]);
    }
}
