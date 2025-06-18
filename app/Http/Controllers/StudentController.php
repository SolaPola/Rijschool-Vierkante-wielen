<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $query = Student::with('user');

        // Apply status filter
        if ($request->has('status')) {
            if ($request->status == 'active') {
                $query->where('isactive', true);
            } elseif ($request->status == 'inactive') {
                $query->where('isactive', false);
            }
        }

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                  ->orWhere('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('relation_number', 'like', "%{$search}%");
        }

        // Get paginated results
        $students = $query->paginate(15);

        // Get additional stats for filters
        $totalStudents = Student::count();
        $activeStudents = Student::where('isactive', true)->count();
        $inactiveStudents = Student::where('isactive', false)->count();

        return view('students.index', compact(
            'students',
            'totalStudents',
            'activeStudents',
            'inactiveStudents'
        ));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Generate a username (lowercase firstname + first letter of lastname + random number)
        $username = strtolower($validated['firstname']) . strtolower(substr($validated['lastname'], 0, 1)) . rand(100, 999);
        
        // Check if username exists and regenerate if needed
        while (User::where('username', $username)->exists()) {
            $username = strtolower($validated['firstname']) . strtolower(substr($validated['lastname'], 0, 1)) . rand(100, 999);
        }
        
        // Get the student role ID
        $studentRole = Role::where('name', 'student')->first();
        if (!$studentRole) {
            return redirect()->back()->withInput()->with('error', 'Student role not found in the system.');
        }
        
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            // Create the user
            $user = User::create([
                'firstname' => $validated['firstname'],
                'infix' => $validated['infix'],
                'lastname' => $validated['lastname'],
                'birthdate' => $validated['birthdate'],
                'username' => $username,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $studentRole->id,
                'is_active' => 1,
            ]);
            
            // Generate a relation number for the student (STD + current year + random string)
            $relationNumber = 'STD-' . date('Y') . '-' . strtoupper(Str::random(5));
            
            // Create the student record
            $student = Student::create([
                'user_id' => $user->id,
                'relation_number' => $relationNumber,
                'isactive' => true,
            ]);
            
            // Commit the transaction
            DB::commit();
            
            return redirect()->route('students.index')
                ->with('success', 'Student created successfully.');
                
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
            
            return redirect()->back()->withInput()
                ->with('error', 'Error creating student: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified student.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        // Load the associated user
        $student->load('user');
        
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        try {
            // Load the associated user
            $student->load('user');
            $user = $student->user;

            // If user doesn't exist, return an error
            if (!$user) {
                return redirect()->back()->withInput()
                    ->with('error', 'User associated with this student not found.');
            }

            // Validate user data
            $validated = $request->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'infix' => ['nullable', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'birthdate' => ['required', 'date'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'phone' => ['nullable', 'string', 'max:20'],
                'relation_number' => ['nullable', 'string', 'max:255'],
                'isactive' => ['boolean'],
            ]);

            // Start a database transaction
            DB::beginTransaction();

            // Update user data
            $userData = [
                'firstname' => $validated['firstname'],
                'infix' => $validated['infix'],
                'lastname' => $validated['lastname'],
                'birthdate' => $validated['birthdate'],
                'email' => $validated['email'],
                'is_active' => $request->has('isactive') ? 1 : 0,
            ];

            // Only update password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            // Update student data
            $student->update([
                'relation_number' => $validated['relation_number'] ?? $student->relation_number,
                'isactive' => $request->has('isactive'),
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            // Redirect to student overview page after successful update
            return redirect()->route('instructors.students')
                ->with('success', 'Student updated successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            
            return redirect()->back()->withInput()
                ->with('error', 'Error updating student: ' . $e->getMessage());
        }
    }

    /**
     * Delete a student and their user account.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function delete(Student $student)
    {
        try {
            DB::beginTransaction();
            
            // Find the user associated with this student
            $user = User::find($student->user_id);
            
            // Delete the student record
            $student->delete();
            
            // Delete the user record if it exists
            if ($user) {
                $user->delete();
            }
            
            DB::commit();
            
            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }
            
            return redirect()->route('students.index')
                ->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            
            return redirect()->route('students.index')
                ->with('error', 'Error deleting student: ' . $e->getMessage());
        }
    }
}
