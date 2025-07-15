<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TripSeeder extends Seeder
{
    /**
     * Seeds the database with 15 trip records with varied status and realistic Brazilian routes.
     *
     * Creates trips using existing vehicles and drivers with different statuses to demonstrate 
     * various stages of trip lifecycle. Includes scheduled, in-progress, completed, and cancelled trips.
     */
    public function run(): void
    {
        // Check if we have vehicles and drivers
        if (Vehicle::count() === 0) {
            $this->command->warn('Nenhum veículo encontrado. Adicione veículos antes de executar o seeder de viagens.');
            return;
        }

        if (Driver::count() === 0) {
            $this->command->warn('Nenhum motorista encontrado. Adicione motoristas antes de executar o seeder de viagens.');
            return;
        }

        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        $specificTrips = [
            [
                'name' => 'Viagem São Paulo - Rio de Janeiro',
                'status' => 'in_progress',
                'departure_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'departure_time' => '08:00',
                'origin' => 'São Paulo',
                'destination' => 'Rio de Janeiro',
                'route' => 'São Paulo → Rio de Janeiro',
                'passenger_price' => 85.50,
                'max_passengers' => 42,
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
            ],
            [
                'name' => 'Expresso Belo Horizonte - Salvador',
                'status' => 'in_progress',
                'departure_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'departure_time' => '14:30',
                'origin' => 'Belo Horizonte',
                'destination' => 'Salvador',
                'route' => 'Belo Horizonte → Salvador',
                'passenger_price' => 125.00,
                'max_passengers' => 38,
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
            ],
            [
                'name' => 'Rota Brasília - Goiânia',
                'status' => 'completed',
                'departure_date' => Carbon::now()->subDays(7)->format('Y-m-d'),
                'departure_time' => '06:45',
                'origin' => 'Brasília',
                'destination' => 'Goiânia',
                'route' => 'Brasília → Goiânia',
                'passenger_price' => 45.00,
                'max_passengers' => 30,
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
            ],
            [
                'name' => 'Viagem Fortaleza - Recife',
                'status' => 'cancelled',
                'departure_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'departure_time' => '22:15',
                'origin' => 'Fortaleza',
                'destination' => 'Recife',
                'route' => 'Fortaleza → Recife',
                'passenger_price' => 95.75,
                'max_passengers' => 45,
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
            ],
            [
                'name' => 'Express Porto Alegre - Florianópolis',
                'status' => 'in_progress',
                'departure_date' => Carbon::now()->addWeeks(2)->format('Y-m-d'),
                'departure_time' => '16:00',
                'origin' => 'Porto Alegre',
                'destination' => 'Florianópolis',
                'route' => 'Porto Alegre → Florianópolis',
                'passenger_price' => 65.00,
                'max_passengers' => 40,
                'vehicle_id' => $vehicles->random()->id,
                'driver_id' => $drivers->random()->id,
            ],
        ];



        foreach ($specificTrips as $tripData) {
            Trip::create($tripData);
        }


        Trip::factory(10)->create([
            'vehicle_id' => fn() => $vehicles->random()->id,
            'driver_id' => fn() => $drivers->random()->id,
        ]);
    }
}
