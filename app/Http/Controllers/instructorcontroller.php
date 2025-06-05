<?php


namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // First try to use Eloquent with relationships
            try {
                $query = Instructor::with('user');
                
                // Add search filtering if provided
                if ($request->has('search') && $request->search) {
                    $search = $request->search;
                    $query->where(function($q) use ($search) {
                        // Search in instructor number
                        $q->where('number', 'like', "%{$search}%")
                          // Or search in user details
                          ->orWhereHas('user', function($q) use ($search) {
                            $q->where('firstname', 'like', "%{$search}%")
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
                
                $instructors = $query->paginate(15);
            } catch (\Exception $eloquentException) {
                // If Eloquent fails, fallback to raw query that includes user data
                $baseQuery = DB::table('instructors')
                    ->join('users', 'instructors.user_id', '=', 'users.id')
                    ->select(
                        'instructors.id', 
                        'instructors.number', 
                        'instructors.isactive',
                        'instructors.user_id',
                        'users.firstname as user_firstname',
                        'users.infix as user_infix',
                        'users.lastname as user_lastname',
                        'users.email as user_email'
                    );
                
                // Add search filtering if provided
                if ($request->has('search') && $request->search) {
                    $search = $request->search;
                    $baseQuery->where(function($q) use ($search) {
                        // Search in instructor number
                        $q->where('instructors.number', 'like', "%{$search}%")
                          // Or search in user details
                          ->orWhere('users.firstname', 'like', "%{$search}%")
                          ->orWhere('users.lastname', 'like', "%{$search}%")
                          ->orWhere('users.email', 'like', "%{$search}%");
                    });
                }
                
                // Filter by active status if provided
                if ($request->has('status') && $request->status != 'all') {
                    $isActive = $request->status === 'active';
                    $baseQuery->where('instructors.isactive', $isActive);
                }
                
                $instructors = $baseQuery->paginate(15);
            }
            
            // Get instructor counts for filter stats
            $totalInstructors = Instructor::count();
            $activeInstructors = Instructor::where('isactive', true)->count();
            $inactiveInstructors = Instructor::where('isactive', false)->count();
            
            return view('instructors.index', compact(
                'instructors',
                'totalInstructors',
                'activeInstructors',
                'inactiveInstructors'
            ));
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Error retrieving instructors: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('accounts.create', ['role' => 'instructor']);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Implementation for storing a new instructor
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Get a specific instructor
            $instructor = collect(DB::select('CALL GetInstructorById(?)', [$id]))->first();
            
            if (!$instructor) {
                return redirect()->route('Instructors.index')
                    ->with('error', 'Instructor not found');
            }
            
            return view('instructors.show', compact('instructor'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error retrieving instructor details: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    // Implementation for edit form
    $instructor = collect(DB::select('CALL GetInstructorById(?)', [$id]))->first();
    
    if (!$instructor) {
        return redirect()->route('Instructors.index')
            ->with('error', 'Instructor not found');
    }
    
    return view('instructors.edit', compact('instructor'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implementation for updating an instructor
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $instructor = Instructor::findOrFail($id);
            $user = User::findOrFail($instructor->user_id);
            
            // Mark as inactive instead of deleting to maintain referential integrity
            $instructor->isactive = false;
            $instructor->save();
            
            return redirect()->route('instructors.index')
                ->with('success', 'Instructor deactivated successfully');
        } catch (\Exception $e) {
            return redirect()->route('instructors.index')
                ->with('error', 'Error deactivating instructor: ' . $e->getMessage());
        }
    }

}