<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Test',
            'infix' => '',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // password
        ]);
        Car::factory(10)->create();
    }
}
