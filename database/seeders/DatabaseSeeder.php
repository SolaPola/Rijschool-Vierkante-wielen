<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Check if test user already exists to avoid duplicate entry errors
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'firstname' => 'Test',
                'infix' => '',
                'lastname' => 'User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}
