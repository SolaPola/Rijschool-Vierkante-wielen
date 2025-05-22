<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Car;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
        $this->call(PackageSeeder::class);
       
      
        User::factory()->create([
            'firstname' => 'Test',
            'infix' => '',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // password
        ]);
        Car::factory(10)->create();
        
        // Create students
        Student::factory(10)->create();
        
        // Create instructors
        Instructor::factory(5)->create();
        
        // Create registrations
        $students = Student::all();
        foreach ($students as $student) {
            Registration::create([
                'student_id' => $student->id,
                'package_id' => rand(1, 3), // Assuming you have package IDs 1-3
                'start_date' => Carbon::now()->format('Y-m-d'), // Add the start_date field
                'end_date' => Carbon::now()->addMonths(6)->format('Y-m-d'), // Optional: Add end_date
                'isactive' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        // Create 50 lessons
        $registrations = Registration::all();
        $instructors = Instructor::all();
        $cars = Car::all();
        $statuses = ['Planned', 'Completed', 'Canceled'];
        
        for ($i = 0; $i < 50; $i++) {
            $startDateTime = Carbon::now()->subDays(rand(0, 30))->addDays(rand(0, 60));
            $startDate = $startDateTime->format('Y-m-d');
            $startTime = $startDateTime->format('H:i:00');
            
            $endDateTime = (clone $startDateTime)->addHours(1);
            $endDate = $endDateTime->format('Y-m-d');
            $endTime = $endDateTime->format('H:i:00');
            
            DB::table('driving_lessons')->insert([
                'registration_id' => $registrations->random()->id,
                'instructor_id' => $instructors->random()->id,
                'car_id' => $cars->random()->id,
                'start_date' => $startDate,
                'start_time' => $startTime,
                'end_date' => $endDate,
                'end_time' => $endTime,
                'lesson_status' => $statuses[array_rand($statuses)],
                'goal' => 'Practice ' . ['parking', 'highway driving', 'city driving', 'lane changing', 'reverse driving'][array_rand(['parking', 'highway driving', 'city driving', 'lane changing', 'reverse driving'])],
                'student_comment' => rand(0, 1) ? 'Student comment ' . $i : null,
                'commentary_instructor' => rand(0, 1) ? 'Instructor comment ' . $i : null,
                'remark' => rand(0, 1) ? 'Remark ' . $i : null,
                'isactive' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        if (!User::where('email', 'test@example.com')->exists()) {

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

    }
}
