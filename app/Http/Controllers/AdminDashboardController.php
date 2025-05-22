<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get the student role id
        $studentRoleId = Role::where('name', 'student')->first()->id;

        // Count total students (active users with student role)
        $totalStudents = User::where('role_id', $studentRoleId)
            ->where('is_active', true)
            ->count();

        // Count total instructors
        $instructorRoleId = Role::where('name', 'instructor')->first()->id;
        $totalInstructors = User::where('role_id', $instructorRoleId)
            ->where('is_active', true)
            ->count();

        // Count scheduled lessons
        $scheduledLessons = Lesson::where('status', 'scheduled')->count();

        // Calculate exam pass rate (this would require exam data, using placeholder for now)
        $passRate = 85; // Placeholder - would need to be calculated from actual exam data

        return view('admin.dashboard', compact('totalStudents', 'totalInstructors', 'scheduledLessons', 'passRate'));
    }
}
