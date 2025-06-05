<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Lesson;
use App\Models\Car;
use App\Models\Instructor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class InstructorDashboardController extends Controller
{
    /**
     * Display the instructor dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Get current instructor
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')
                    ->with('error', 'You must be logged in to access this page.');
            }
            
            $instructor = null;
            
            // Try to get instructor in multiple ways to handle different possible structures
            if (isset($user->instructor) && $user->instructor) {
                $instructor = $user->instructor;
            } else {
                $instructor = Instructor::where('user_id', $user->id)->first();
            }
            
            if (!$instructor) {
                Log::warning('User accessing instructor dashboard without instructor profile', [
                    'user_id' => $user->id,
                    'role' => $user->role->name ?? 'No role'
                ]);
                
                return redirect('/dashboard')
                    ->with('error', 'Instructor profile not found. Please contact an administrator.');
            }
            
            $instructorId = $instructor->id;
            
            // Get upcoming lessons
            $upcomingLessons = collect([]);
            
            try {
                // First try with standard column names
                $upcomingLessons = Lesson::where('instructor_id', $instructorId)
                    ->where(function($query) {
                        $query->where('status', 'scheduled')
                            ->orWhere('status', 'confirmed')
                            ->orWhere('lesson_status', 'Planned');
                    })
                    ->where(function($query) {
                        $query->where('start_time', '>', now());
                    })
                    ->with(['student.user', 'car'])
                    ->orderBy('start_time')
                    ->take(5)
                    ->get();
            } catch (\Exception $columnException) {
                // If that fails, try with alternative column names
                try {
                    $upcomingLessons = Lesson::where('instructor_id', $instructorId)
                        ->where(function($query) {
                            $query->where('lesson_status', 'Planned');
                        })
                        ->where(function($query) {
                            $query->where('start_datetime', '>', now());
                        })
                        ->with(['student.user', 'car'])
                        ->orderBy('start_datetime')
                        ->take(5)
                        ->get();
                } catch (\Exception $e2) {
                    // If both fail, log the error but continue with empty collection
                    Log::error('Error fetching upcoming lessons: ' . $e2->getMessage());
                    $upcomingLessons = collect([]);
                }
            }
            
            // Get student count and recent students
            $studentIds = collect([]);
            
            try {
                $studentIds = Lesson::where('instructor_id', $instructorId)
                    ->distinct('student_id')
                    ->pluck('student_id');
            } catch (\Exception $e) {
                Log::error('Error fetching student IDs: ' . $e->getMessage());
                $studentIds = collect([]);
            }
                
            $studentCount = $studentIds->count();
            
            $recentStudents = collect([]);
            
            if ($studentIds->isNotEmpty()) {
                try {
                    $recentStudents = Student::whereIn('id', $studentIds)
                        ->with('user')
                        ->take(5)
                        ->get();
                } catch (\Exception $e) {
                    Log::error('Error fetching recent students: ' . $e->getMessage());
                    $recentStudents = collect([]);
                }
            }
            
            // Get available cars count
            $carsCount = 0;
            try {
                $carsCount = Car::where('isactive', true)->count();
            } catch (\Exception $e) {
                Log::error('Error counting cars: ' . $e->getMessage());
            }
            
            // Get upcoming lesson count
            $upcomingLessonsCount = 0;
            try {
                $upcomingLessonsCount = Lesson::where('instructor_id', $instructorId)
                    ->where(function($query) {
                        $query->where('status', 'scheduled')
                            ->orWhere('status', 'confirmed')
                            ->orWhere('lesson_status', 'Planned');
                    })
                    ->where(function($query) {
                        $query->where('start_time', '>', now())
                            ->orWhere('start_datetime', '>', now());
                    })
                    ->count();
            } catch (\Exception $e) {
                Log::error('Error counting upcoming lessons: ' . $e->getMessage());
            }
            
            return view('instructors.dashboard', compact(
                'upcomingLessons',
                'recentStudents',
                'studentCount',
                'carsCount',
                'upcomingLessonsCount'
            ));
        } catch (\Exception $e) {
            Log::error('Error in instructor dashboard: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect('/dashboard')
                ->with('error', 'Error loading instructor dashboard. Please try again or contact support.');
        }
    }
    
    /**
     * Display the instructor's students.
     *
     * @return \Illuminate\Http\Response
     */
    public function students()
    {
        try {
            // Get current instructor
            $instructorId = Auth::user()->instructor->id ?? null;
            
            if (!$instructorId) {
                return redirect()->route('dashboard')
                    ->with('error', 'Instructor profile not found.');
            }
            
            // Get all student IDs that have lessons with this instructor
            $studentIds = Lesson::where('instructor_id', $instructorId)
                ->distinct('student_id')
                ->pluck('student_id');
            
            // Get all students with these IDs
            $students = Student::whereIn('id', $studentIds)
                ->with('user')
                ->paginate(10);
            
            return view('instructors.students', compact('students'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error loading students: ' . $e->getMessage());
        }
    }
}