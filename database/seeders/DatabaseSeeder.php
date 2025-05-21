<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users for each role

        // Admin user
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'firstname' => 'Admin',
                'infix' => '',
                'lastname' => 'User',
                'username' => 'admin',
                'birthdate' => '1990-01-01',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'administrator')->first()->id,
            ]);
        }

        // Instructor user
        if (!User::where('email', 'instructor@example.com')->exists()) {
            User::factory()->create([
                'firstname' => 'Instructor',
                'infix' => '',
                'lastname' => 'User',
                'username' => 'instructor',
                'birthdate' => '1985-05-15',
                'email' => 'instructor@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'instructor')->first()->id,
            ]);
        }

        // Student user
        if (!User::where('email', 'student@example.com')->exists()) {
            User::factory()->create([
                'firstname' => 'Student',
                'infix' => '',
                'lastname' => 'User',
                'username' => 'student',
                'birthdate' => '2000-10-20',
                'email' => 'student@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'student')->first()->id,
            ]);
        }
    }
}
