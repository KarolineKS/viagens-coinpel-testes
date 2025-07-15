<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'registration_number' => $this->faker->unique()->numerify('######'),
            'cpf' => $this->faker->unique()->numerify('###########'),
            'rg' => $this->faker->unique()->numerify('##########'),
            'zip_code' => $this->faker->numerify('#####-###'),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('(##) #####-####'),
            'cnh_category' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'AB', 'AC', 'AD', 'AE']),
            'cnh_number' => $this->faker->unique()->numerify('##########'),
            'cnh_expiry_date' => $this->faker->dateTimeBetween('+1 month', '+5 years')->format('Y-m-d'),
            'profile_photo' => null,
        ];
    }
}
