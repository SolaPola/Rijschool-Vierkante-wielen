<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Role;
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
        // Get the student role ID
        $studentRoleId = Role::where('name', 'student')->first()->id;

        // Get all users with the student role
        $studentUsers = User::where('role_id', $studentRoleId)
            ->where('is_active', true)
            ->get();

        // Get additional student data from the students table if it exists
        $students = [];
        foreach ($studentUsers as $user) {
            $studentData = Student::where('user_id', $user->id)->first();

            // Create a package and progress simulation (in a real app, this would come from your database)
            $packages = ['Starter (10 Lessons)', 'Standard (20 Lessons)', 'Comprehensive (30 Lessons)', 'Intensive (40 Lessons)'];
            $progress = rand(0, 100);
            $status = $progress == 100 ? 'completed' : ($progress < 25 ? 'on-hold' : 'active');

            $students[] = [
                'id' => $user->id,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'infix' => $user->infix,
                'email' => $user->email,
                'phone' => '+31 6 ' . rand(10000000, 99999999), // Simulated phone number
                'package' => $packages[array_rand($packages)],
                'start_date' => Carbon::parse($user->created_at)->format('d-m-Y'),
                'instructor' => 'Mark Wilson', // This would normally come from your relationships
                'progress' => $progress,
                'status' => $status,
                'relation_number' => $studentData ? $studentData->relation_number : 'N/A',
                'remark' => $studentData ? $studentData->remark : null,
            ];
        }

        // Calculate stats for the dashboard
        $totalStudents = count($students);
        $passedExams = count(array_filter($students, function ($s) {
            return $s['progress'] == 100;
        }));
        $activePackages = count(array_filter($students, function ($s) {
            return $s['status'] == 'active';
        }));
        $upcomingExams = rand(3, 10); // Simulated count for upcoming exams

        return view('instructor.studentOverzicht', compact(
            'students',
            'totalStudents',
            'passedExams',
            'activePackages',
            'upcomingExams'
        ));
    }
}
