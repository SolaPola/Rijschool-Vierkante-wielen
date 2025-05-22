<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Instructor;
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
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Test',
            'infix' => '',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // password
        ]);
        // Car::factory(10)->create();
        
        // // Create students
        // Student::factory(10)->create();
        
        // // Create instructors
        // Instructor::factory(5)->create();
        
        // // Create registrations
        // $students = Student::all();
        // foreach ($students as $student) {
        //     Registration::create([
        //         'student_id' => $student->id,
        //         'package_id' => rand(1, 3), // Assuming you have package IDs 1-3
        //         'start_date' => Carbon::now()->format('Y-m-d'), // Add the start_date field
        //         'end_date' => Carbon::now()->addMonths(6)->format('Y-m-d'), // Optional: Add end_date
        //         'isactive' => true,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // }
        
        // // Create 50 lessons
        // $registrations = Registration::all();
        // $instructors = Instructor::all();
        // $cars = Car::all();
        // $statuses = ['Planned', 'Completed', 'Canceled'];
        
        // for ($i = 0; $i < 50; $i++) {
        //     $startDateTime = Carbon::now()->subDays(rand(0, 30))->addDays(rand(0, 60));
        //     $startDate = $startDateTime->format('Y-m-d');
        //     $startTime = $startDateTime->format('H:i:00');
            
        //     $endDateTime = (clone $startDateTime)->addHours(1);
        //     $endDate = $endDateTime->format('Y-m-d');
        //     $endTime = $endDateTime->format('H:i:00');
            
        //     DB::table('driving_lessons')->insert([
        //         'registration_id' => $registrations->random()->id,
        //         'instructor_id' => $instructors->random()->id,
        //         'car_id' => $cars->random()->id,
        //         'start_date' => $startDate,
        //         'start_time' => $startTime,
        //         'end_date' => $endDate,
        //         'end_time' => $endTime,
        //         'lesson_status' => $statuses[array_rand($statuses)],
        //         'goal' => 'Practice ' . ['parking', 'highway driving', 'city driving', 'lane changing', 'reverse driving'][array_rand(['parking', 'highway driving', 'city driving', 'lane changing', 'reverse driving'])],
        //         'student_comment' => rand(0, 1) ? 'Student comment ' . $i : null,
        //         'commentary_instructor' => rand(0, 1) ? 'Instructor comment ' . $i : null,
        //         'remark' => rand(0, 1) ? 'Remark ' . $i : null,
        //         'isactive' => true,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // }
    }
}
