<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    /**
     * Display the instructor dashboard.
     */
    public function index()
    {
        return view('instructor.dashboard');
    }

    /**
     * Display the instructor's students page.
     */
    public function students()
    {
        // Get the currently authenticated instructor
        $instructor = Auth::user();

        // Mock data for students (in a real application, this would come from the database)
        $students = [
            [
                'firstname' => 'John',
                'infix' => '',
                'lastname' => 'Doe',
                'relation_number' => 'STD-2023-001',
                'email' => 'john.doe@example.com',
                'phone' => '06-12345678',
                'package' => 'Standard (20 Lessons)',
                'start_date' => '01-03-2024',
                'instructor' => $instructor->firstname . ' ' . $instructor->lastname,
                'status' => 'active',
            ],
            [
                'firstname' => 'Jane',
                'infix' => 'van',
                'lastname' => 'Smith',
                'relation_number' => 'STD-2023-002',
                'email' => 'jane.smith@example.com',
                'phone' => '06-23456789',
                'package' => 'Comprehensive (30 Lessons)',
                'start_date' => '15-02-2024',
                'instructor' => $instructor->firstname . ' ' . $instructor->lastname,
                'status' => 'active',
            ],
            [
                'firstname' => 'Robert',
                'infix' => 'de',
                'lastname' => 'Johnson',
                'relation_number' => 'STD-2023-003',
                'email' => 'robert.johnson@example.com',
                'phone' => '06-34567890',
                'package' => 'Starter (10 Lessons)',
                'start_date' => '10-01-2024',
                'instructor' => $instructor->firstname . ' ' . $instructor->lastname,
                'status' => 'completed',
            ],
            [
                'firstname' => 'Emma',
                'infix' => '',
                'lastname' => 'Williams',
                'relation_number' => 'STD-2023-004',
                'email' => 'emma.williams@example.com',
                'phone' => '06-45678901',
                'package' => 'Intensive (40 Lessons)',
                'start_date' => '05-04-2024',
                'instructor' => $instructor->firstname . ' ' . $instructor->lastname,
                'status' => 'on-hold',
            ],
        ];

        // Statistics for the dashboard cards
        $totalStudents = count($students);
        $passedExams = 12; // Mock data
        $activePackages = 25; // Mock data
        $upcomingExams = 8; // Mock data

        return view('instructor.studentOverzicht', compact(
            'students',
            'totalStudents',
            'passedExams',
            'activePackages',
            'upcomingExams'
        ));
    }
}
