<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        // If a role filter is applied, filter users by role
        if ($request->has('role')) {
            $roleName = $request->get('role');
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $users = User::with('role')
                    ->where('role_id', $role->id);

                // Add search filtering for instructors
                if ($roleName === 'instructor' && $request->has('search') && $request->search) {
                    $search = $request->search;
                    $users = $users->where(function ($query) use ($search) {
                        $query->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                $users = $users->paginate(15);
            } else {
                // If role doesn't exist, show all users
                $users = User::with('role')->paginate(15);
            }
        } else {
            // No filter, show all users
            $users = User::with('role')->paginate(15);
        }

        // Get counts for the role filters
        $totalUsers = User::count();
        $adminCount = User::whereHas('role', function ($query) {
            $query->where('name', 'administrator');
        })->count();
        $instructorCount = User::whereHas('role', function ($query) {
            $query->where('name', 'instructor');
        })->count();
        $studentCount = User::whereHas('role', function ($query) {
            $query->where('name', 'student');
        })->count();

        return view('accounts.index', compact(
            'users',
            'totalUsers',
            'adminCount',
            'instructorCount',
            'studentCount'
        ));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('accounts.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        // Set is_active to true by default
        $validated['is_active'] = 1;

        User::create($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('accounts.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('accounts.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'infix' => ['nullable', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'birthdate' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'is_active' => ['boolean'],
            'note' => ['nullable', 'string']
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->has('is_active');

        $user->update($validated);

        return redirect()->route('accounts.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'User deleted successfully');
    }

    /**
     * Display a listing of the students.
     *
     * @return \Illuminate\Http\Response
     */
    public function students()
    {
        try {
            $studentRole = Role::where('name', 'student')->first();

            if (!$studentRole) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Student role not defined in the system');
            }

            $students = Student::with('user')
                ->whereHas('user', function ($query) use ($studentRole) {
                    $query->where('role_id', $studentRole->id);
                })
                ->paginate(15);

            return view('students.index', compact('students'));
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
    public function deleteStudent($id)
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
