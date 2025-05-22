<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // First we need to create the GetInstructors stored procedure if it doesn't exist
            DB::unprepared("
            CREATE PROCEDURE IF NOT EXISTS GetInstructors()
            BEGIN
                SELECT 
                    i.id,
                    i.number AS license_number,
                    i.isactive,
                    i.remark,
                    CONCAT(u.firstname, ' ', IF(u.infix IS NOT NULL AND u.infix != '', CONCAT(u.infix, ' '), ''), u.lastname) AS name,
                    u.email,
                    u.username,
                    u.birthdate,
                    u.is_active AS user_status,
                    u.created_at,
                    u.updated_at,
                    CASE 
                        WHEN i.isactive = 1 AND u.is_active = 1 THEN 'Active'
                        WHEN i.isactive = 0 THEN 'Inactive'
                        ELSE 'On Leave'
                    END AS status
                FROM instructors i
                INNER JOIN users u ON i.user_id = u.id;
            END;
            ");
            
            // Call the stored procedure to get all instructors
            $instructorsData = DB::select('CALL GetInstructors()');
            
            // Convert to collection for easier manipulation
            $instructorsCollection = collect($instructorsData);
            
            // Calculate statistics for dashboard cards
            $totalInstructors = $instructorsCollection->count();
            $certifiedInstructors = $instructorsCollection->where('isactive', 1)->count();
            $activeInstructors = $instructorsCollection->where('status', 'Active')->count();
            
            // Manual pagination since stored procedures can't be paginated directly
            $page = request()->get('page', 1);
            $perPage = 10;
            
            $offset = ($page - 1) * $perPage;
            $instructorsForCurrentPage = $instructorsCollection->slice($offset, $perPage);
            
            // Create a custom paginator
            $instructors = new LengthAwarePaginator(
                $instructorsForCurrentPage,
                $instructorsCollection->count(),
                $perPage,
                $page,
                ['path' => request()->url()]
            );
            
            return view('instructors.index', compact(
                'instructors', 
                'totalInstructors', 
                'certifiedInstructors', 
                'activeInstructors'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Error retrieving instructors: ' . $e->getMessage());
        }
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instructors.create');
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
          DB::statement('CALL DeleteDrivingLesson(?)', [$id]);
        
        return redirect()->route('Lessons.index')
            ->with('success', 'Driving lesson deleted successfully');
    }

}