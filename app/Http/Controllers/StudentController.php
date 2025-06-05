<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Get student role
            $studentRole = Role::where('name', 'student')->first();
            
            if (!$studentRole) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Student role not defined in the system');
            }
            
            // Start query to get all students with their user data
            $query = Student::with('user')
                ->whereHas('user', function($query) use ($studentRole) {
                    $query->where('role_id', $studentRole->id);
                });
            
            // Add search filtering if provided
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    // Search in student relation number
                    $q->where('relation_number', 'like', "%{$search}%")
                      // Or search in user details
                      ->orWhereHas('user', function($userQuery) use ($search) {
                        $userQuery->where('firstname', 'like', "%{$search}%")
                              ->orWhere('lastname', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
                    });
                });
            }
            
            // Filter by active status if provided
            if ($request->has('status') && $request->status != 'all') {
                $isActive = $request->status === 'active';
                $query->where('isactive', $isActive);
            }
            
            // Execute query with pagination
            $students = $query->paginate(15);
            
            // Get student counts for filter stats
            $totalStudents = Student::count();
            $activeStudents = Student::where('isactive', true)->count();
            $inactiveStudents = Student::where('isactive', false)->count();
            
            return view('students.index', compact(
                'students',
                'totalStudents',
                'activeStudents',
                'inactiveStudents'
            ));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Error retrieving students: ' . $e->getMessage());
        }
    }

    /**
     * Mark a student as inactive (soft delete).
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $student = Student::findOrFail($id);
            
            // Mark as inactive instead of deleting
            $student->isactive = false;
            $student->save();
            
            return redirect()->route('students.index')
                ->with('success', 'Student deactivated successfully');
        } catch (\Exception $e) {
            return redirect()->route('students.index')
                ->with('error', 'Error deactivating student: ' . $e->getMessage());
        }
    }
}
