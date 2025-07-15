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
        // Use Brazilian faker locale for valid Brazilian documents
        $faker = \Faker\Factory::create('pt_BR');

        return [
            'name' => $faker->name(),
            'birth_date' => $faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
            'registration_number' => $faker->unique()->numerify('######'),
            'cpf' => $faker->unique()->cpf(false),
            'rg' => $faker->unique()->rg(false),
            'zip_code' => $faker->postcode(),
            'street' => $faker->streetName(),
            'number' => $faker->buildingNumber(),
            'city' => $faker->city(),
            'state' => $faker->stateAbbr(),
            'email' => $faker->unique()->safeEmail(),
            'phone' => $faker->cellphone(false),
            'cnh_category' => $faker->randomElement(['A', 'B', 'C', 'D', 'E', 'AB', 'AC', 'AD', 'AE']),
            'cnh_number' => $faker->unique()->numerify('##########'),
            'cnh_expiry_date' => $faker->dateTimeBetween('+1 month', '+5 years')->format('Y-m-d'),
            'profile_photo' => null,
        ];
    }
}
