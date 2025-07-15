<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');

        for ($i = 1; $i <= 10; $i++) {
            Driver::create([
                'name' => "Driver Test {$i} " . $faker->lastName,
                'birth_date' => $faker->dateTimeBetween('1970-01-01', '1995-12-31')->format('Y-m-d'),
                'registration_number' => str_pad($i, 6, '0', STR_PAD_LEFT),
                'cpf' => $faker->cpf(false),
                'rg' => $faker->rg(false),
                'zip_code' => $faker->postcode,
                'street' => $faker->streetName,
                'number' => $faker->buildingNumber,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'email' => "test.driver{$i}@example.com",
                'phone' => $faker->cellphone(false),
                'cnh_category' => $faker->randomElement(['A', 'B', 'C', 'D', 'E']),
                'cnh_number' => $faker->numerify('#######'),
                'cnh_expiry_date' => $i === 4
                    ? Carbon::now()->subMonths(6)->format('Y-m-d')
                    : $faker->dateTimeBetween('2025-01-01', '2026-12-31')->format('Y-m-d'),
            ]);
        }
    }
}
