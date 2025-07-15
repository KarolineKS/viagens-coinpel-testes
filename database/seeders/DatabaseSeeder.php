<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeds the application's database with initial data.
     *
     * Creates a test user with predefined attributes and executes the DriverSeeder to populate related data.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'first_login' => true,
            'is_blocked' => false,
        ]);

        $this->call([
            DriverSeeder::class,
        ]);
    }
}
