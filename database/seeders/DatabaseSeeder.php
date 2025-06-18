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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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

        // Create instructor records for existing instructor users
        $this->createInstructorRecords();
        
        // Create student records for existing student users
        $this->createStudentRecords();

        // Call the Package seeder
        $this->call(PackageSeeder::class);
        
        // Create cars using factory
        $this->seedCars();
        
        // Create 200 lessons
        $this->seedLessons(200);
    }
    
    /**
     * Create instructor records for existing users
     */
    private function createInstructorRecords()
    {
        $instructorRole = Role::where('name', 'instructor')->first();
        if (!$instructorRole) {
            $this->command->error('Instructor role not found');
            return;
        }
        
        //Instructor user
        if (!User::where('email', 'instructor@example.com')->exists()) {
            $user = User::factory()->create([
                'firstname' => 'Instructor',
                'infix' => '',
                'lastname' => 'User',
                'username' => 'instructor',
                'birthdate' => '1985-05-15',
                'email' => 'instructor@example.com',
                'password' => bcrypt('password'),
                'role_id' => $instructorRole->id,
            ]);
            
            // Create instructor record if it doesn't exist
            if (!Instructor::where('user_id', $user->id)->exists()) {
                Instructor::create([
                    'user_id' => $user->id,
                    'number' => 'INST-001',
                    'isactive' => true,
                ]);
            }
        }
        
        // Create 10 named instructors with deterministic data
        $instructorNames = [
            ['firstname' => 'John', 'lastname' => 'Smith'],
            ['firstname' => 'Emily', 'lastname' => 'Johnson'],
            ['firstname' => 'Michael', 'lastname' => 'Williams'],
            ['firstname' => 'Sarah', 'lastname' => 'Davis'],
            ['firstname' => 'Robert', 'lastname' => 'Miller'],
            ['firstname' => 'Jennifer', 'lastname' => 'Wilson'],
            ['firstname' => 'David', 'lastname' => 'Taylor'],
            ['firstname' => 'Lisa', 'lastname' => 'Anderson'],
            ['firstname' => 'James', 'lastname' => 'Thomas'],
            ['firstname' => 'Jessica', 'lastname' => 'Martinez']
        ];
        
        foreach ($instructorNames as $index => $name) {
            $email = strtolower($name['firstname'] . '.' . $name['lastname'] . '@example.com');
            
            if (!User::where('email', $email)->exists()) {
                $user = User::factory()->create([
                    'firstname' => $name['firstname'],
                    'infix' => '',
                    'lastname' => $name['lastname'],
                    'username' => strtolower($name['firstname'] . $name['lastname']),
                    'birthdate' => fake()->date('Y-m-d', '-30 years'),
                    'email' => $email,
                    'password' => bcrypt('password'),
                    'role_id' => $instructorRole->id,
                ]);
                
                //Create instructor record
                Instructor::create([
                    'user_id' => $user->id,
                    'number' => 'INST-' . str_pad($index + 2, 3, '0', STR_PAD_LEFT), // Start from 002 since 001 is for the main instructor
                    'isactive' => true,
                    'remark' => fake()->optional(0.3)->sentence(),
                ]);
                
                $this->command->info("Created instructor: {$name['firstname']} {$name['lastname']}");
            }
        }
        
        //Ensure all instructor users have instructor records
        $instructorUsers = User::where('role_id', $instructorRole->id)->get();
        
        foreach ($instructorUsers as $user) {
            if (!Instructor::where('user_id', $user->id)->exists()) {
                Instructor::create([
                    'user_id' => $user->id,
                    'number' => 'INST-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                    'isactive' => true,
                ]);
                $this->command->info("Created instructor record for {$user->firstname} {$user->lastname}");
            }
        }
    }
    
    /**
     * Create student records for existing users
     */
    private function createStudentRecords()
    {
        $studentRole = Role::where('name', 'student')->first();
        if (!$studentRole) {
            $this->command->error('Student role not found');
            return;
        }
        
        // Student user
        if (!User::where('email', 'student@example.com')->exists()) {
            $user = User::factory()->create([
                'firstname' => 'Student',
                'infix' => '',
                'lastname' => 'User',
                'username' => 'student',
                'birthdate' => '2000-10-20',
                'email' => 'student@example.com',
                'password' => bcrypt('password'),
                'role_id' => $studentRole->id,
            ]);
            
            // Create student record
            if (!Student::where('user_id', $user->id)->exists()) {
                Student::create([
                    'user_id' => $user->id,
                    'relation_number' => 'STU-0001',
                    'isactive' => true,
                ]);
            }
        }
        
        // Create 10 additional students
        for ($i = 1; $i <= 10; $i++) {
            if (!User::where('email', "student{$i}@example.com")->exists()) {
                $user = User::factory()->create([
                    'firstname' => "Student{$i}",
                    'infix' => '',
                    'lastname' => 'Test',
                    'username' => "student{$i}",
                    'birthdate' => fake()->date('Y-m-d', '-18 years'),
                    'email' => "student{$i}@example.com",
                    'password' => bcrypt('password'),
                    'role_id' => $studentRole->id,
                ]);
                
                // Create student record
                if (!Student::where('user_id', $user->id)->exists()) {
                    Student::create([
                        'user_id' => $user->id,
                        'relation_number' => 'STU-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                        'isactive' => true,
                    ]);
                }
            }
        }
        
        // Ensure all student users have student records
        $studentUsers = User::where('role_id', $studentRole->id)->get();
        
        foreach ($studentUsers as $user) {
            if (!Student::where('user_id', $user->id)->exists()) {
                Student::create([
                    'user_id' => $user->id,
                    'relation_number' => 'STU-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
                    'isactive' => true,
                ]);
                $this->command->info("Created student record for {$user->firstname} {$user->lastname}");
            }
        }
    }
    
    /**
     * Seed cars using CarFactory
     */
    private function seedCars()
    {
        // Create 10 cars using the existing Car factory if none exist
        if (Car::count() == 0) {
            Car::factory(10)->create();
            $this->command->info('Created 10 cars');
        }
    }
    
    /**
     * Seed lessons table
     * 
     * @param int $count Number of lessons to create
     */
    private function seedLessons($count = 200)
    {
        // Get instructors from database
        $instructors = Instructor::all();
        if ($instructors->isEmpty()) {
            $this->command->error('No instructors found in the database');
            return;
        }
        
        // Get students from database
        $students = Student::all();
        if ($students->isEmpty()) {
            $this->command->error('No students found in the database');
            return;
        }
        
        // Get cars from database
        $cars = Car::all();
        if ($cars->isEmpty()) {
            $this->command->error('No cars found in the database');
            return;
        }

        $this->command->info("Creating {$count} lessons with {$instructors->count()} instructors, {$students->count()} students, and {$cars->count()} cars");
        
        // Lesson statuses and titles
        $lessonStatuses = ['scheduled', 'confirmed', 'completed', 'cancelled'];
        $lessonTitles = [
            'Basic Vehicle Control',
            'City Driving Practice',
            'Highway Driving',
            'Parking Practice',
            'Emergency Maneuvers',
            'Night Driving',
            'Defensive Driving',
            'Pre-Exam Practice',
            'Traffic Light Navigation',
            'Roundabout Mastery',
            'Parallel Parking',
            'Reverse Parking',
            'Lane Changing',
            'Overtaking Safely',
            'Rural Road Driving'
        ];
        
        // Delete existing lessons to avoid duplication
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Lesson::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $this->command->info('Removed existing lessons');
        
        $lessonsCreated = 0;
        
        // Create lessons batch by batch to improve performance
        $batchSize = 20;
        $batches = ceil($count / $batchSize);
        
        $this->command->info("Creating lessons in {$batches} batches of {$batchSize}");
        
        for ($batch = 0; $batch < $batches; $batch++) {
            $lessonBatch = [];
            $batchCount = min($batchSize, $count - $lessonsCreated);
            
            for ($i = 0; $i < $batchCount; $i++) {
                $instructor = $instructors->random();
                $student = $students->random();
                $car = $cars->random();
                
                // Weight the statuses to have more planned/completed than cancelled
                $statusRand = rand(1, 10);
                if ($statusRand <= 4) {
                    $status = 'scheduled'; // 40% chance
                } elseif ($statusRand <= 8) {
                    $status = 'completed'; // 40% chance
                } elseif ($statusRand <= 9) {
                    $status = 'confirmed'; // 10% chance
                } else {
                    $status = 'cancelled'; // 10% chance
                }
                
                $title = $lessonTitles[array_rand($lessonTitles)];
                
                // Create realistic date/time for lesson
                if ($status === 'completed' || $status === 'cancelled') {
                    // Past lesson (between 60 days ago and yesterday)
                    $startTime = Carbon::now()->subDays(rand(1, 60))
                                ->setTime(rand(8, 18), [0, 15, 30, 45][rand(0, 3)], 0);
                } else {
                    // Future lesson (between tomorrow and 30 days in future)
                    $startTime = Carbon::now()->addDays(rand(1, 30))
                                ->setTime(rand(8, 18), [0, 15, 30, 45][rand(0, 3)], 0);
                }
                
                $endTime = (clone $startTime)->addMinutes(45);
                
                try {
                    $lesson = Lesson::create([
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
                    
                    $lessonsCreated++;
                    
                } catch (\Exception $e) {
                    $this->command->error("Error creating lesson: " . $e->getMessage());
                }
            }
            
            $this->command->info("Created batch " . ($batch + 1) . " ({$lessonsCreated} lessons total)");
        }
        
        $this->command->info("Successfully created {$lessonsCreated} lessons");
    }
}
