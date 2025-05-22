<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Car;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\Package;
use App\Models\Registration;
use App\Models\Lesson;
use Carbon\Carbon;
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

        // Create 10 additional students
        for ($i = 1; $i <= 10; $i++) {
            if (!User::where('email', "student{$i}@example.com")->exists()) {
                User::factory()->create([
                    'firstname' => "Student{$i}",
                    'infix' => '',
                    'lastname' => 'Test',
                    'username' => "student{$i}",
                    'birthdate' => fake()->date('Y-m-d', '-18 years'),
                    'email' => "student{$i}@example.com",
                    'password' => bcrypt('password'),
                    'role_id' => Role::where('name', 'student')->first()->id,
                ]);
            }
        }

        // Call the Package seeder
        $this->call(PackageSeeder::class);
        
        // Create cars using factory
        $this->seedCars();
        
        // Create lessons
        $this->seedLessons();
    }
    
    /**
     * Seed cars using CarFactory
     */
    private function seedCars()
    {
        // Create 10 cars using the existing Car factory
        Car::factory(10)->create();
    }
    
    /**
     * Seed lessons table
     */
    private function seedLessons()
    {
        // Get users with instructor role
        $instructors = User::where('role_id', Role::where('name', 'instructor')->first()->id)->get();
        
        // Get users with student role
        $students = User::where('role_id', Role::where('name', 'student')->first()->id)->get();
        
        // Get cars 
        $cars = Car::where('isactive', true)->get();
        
        if ($instructors->isEmpty() || $students->isEmpty() || $cars->isEmpty()) {
            return;
        }

        $lessonStatuses = ['scheduled', 'confirmed', 'completed', 'cancelled'];
        $lessonTitles = [
            'Basic Vehicle Control',
            'City Driving Practice',
            'Highway Driving',
            'Parking Practice',
            'Emergency Maneuvers',
            'Night Driving',
            'Defensive Driving',
            'Pre-Exam Practice'
        ];

        // Create 50 lessons
        for ($i = 0; $i < 50; $i++) {
            $student = $students->random();
            $instructor = $instructors->random();
            $car = $cars->random();
            
            $status = $lessonStatuses[array_rand($lessonStatuses)];
            $title = $lessonTitles[array_rand($lessonTitles)];
            
            // Create date/time for lesson
            $startTime = Carbon::now()->subDays(rand(-30, 30))
                         ->setTime(rand(8, 18), [0, 15, 30, 45][rand(0, 3)], 0);
            $endTime = (clone $startTime)->addMinutes(45);

            Lesson::create([
                'instructor_id' => $instructor->id,
                'student_id' => $student->id,
                'title' => $title,
                'description' => fake()->paragraph(2),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => $status,
                'notes' => $status === 'completed' ? fake()->paragraph(1) : null,
                'vehicle_id' => $car->id,
            ]);
        }
    }
}