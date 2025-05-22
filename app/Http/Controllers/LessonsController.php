<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Registration;

class LessonsController extends Controller
{
    /**
     * Display a listing of driving lessons.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all lessons using stored procedure
        $allLessons = collect(DB::select('CALL GetAllDrivingLessons()'));
        
        // Calculate totals for stats
        $totalLessons = $allLessons->count();
        $plannedLessons = $allLessons->where('lesson_status', 'Planned')->count();
        $completedLessons = $allLessons->where('lesson_status', 'Completed')->count();
        $canceledLessons = $allLessons->where('lesson_status', 'Canceled')->count();
        
        // Paginate the collection manually
        $page = request()->get('page', 1);
        $perPage = 20;
        $currentPageItems = $allLessons->slice(($page - 1) * $perPage, $perPage)->values();
        
        // Create a paginator manually
        $lessons = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $totalLessons,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('lessons.index', compact(
            'lessons', 
            'totalLessons', 
            'plannedLessons', 
            'completedLessons', 
            'canceledLessons'
        ));
    }

    /**
     * Show the form for creating a new driving lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $registrations = Registration::where('isactive', true)->get();
        $instructors = Instructor::where('isactive', true)->get();
        $cars = Car::where('isactive', true)->get();
        
        return view('lessons.create', compact('registrations', 'instructors', 'cars'));
    }

    /**
     * Store a newly created driving lesson in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'instructor_id' => 'required|exists:instructors,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
            'lesson_status' => 'required|in:Planned,Completed,Canceled',
            'goal' => 'nullable|string',
            'student_comment' => 'nullable|string',
            'commentary_instructor' => 'nullable|string',
            'remark' => 'nullable|string'
        ]);

        // Format start and end datetime
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'] . ':00';
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'] . ':00';
        
        // Call the stored procedure to insert a new driving lesson
        DB::statement('CALL InsertDrivingLesson(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $validated['registration_id'],
            $validated['instructor_id'],
            $validated['car_id'],
            $startDateTime,
            $endDateTime,
            $validated['lesson_status'],
            $validated['goal'] ?? null,
            $validated['student_comment'] ?? null,
            $validated['commentary_instructor'] ?? null,
            $validated['remark'] ?? null
        ]);

        return redirect()->route('Lessons.index')
            ->with('success', 'Driving lesson created successfully');
    }

    /**
     * Display the specified driving lesson.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id]);
        
        if (empty($lesson)) {
            return redirect()->route('Lessons.index')
                ->with('error', 'Driving lesson not found');
        }

        $lesson = $lesson[0];
        return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified driving lesson.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id]);
        
        if (empty($lesson)) {
            return redirect()->route('Lessons.index')
                ->with('error', 'Driving lesson not found');
        }

        $lesson = $lesson[0];
        $registrations = Registration::where('isactive', true)->get();
        $instructors = Instructor::where('isactive', true)->get();
        $cars = Car::where('isactive', true)->get();

        return view('lessons.edit', compact('lesson', 'registrations', 'instructors', 'cars'));
    }

    /**
     * Update the specified driving lesson in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'instructor_id' => 'required|exists:instructors,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
            'lesson_status' => 'required|in:Planned,Completed,Canceled',
            'goal' => 'nullable|string',
            'student_comment' => 'nullable|string',
            'commentary_instructor' => 'nullable|string',
            'isactive' => 'boolean',
            'remark' => 'nullable|string'
        ]);

        // Format start and end datetime
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'] . ':00';
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'] . ':00';
        
        // Call the stored procedure to update the driving lesson
        DB::statement('CALL UpdateDrivingLesson(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $validated['registration_id'],
            $validated['instructor_id'],
            $validated['car_id'],
            $startDateTime,
            $endDateTime,
            $validated['lesson_status'],
            $validated['goal'] ?? null,
            $validated['student_comment'] ?? null,
            $validated['commentary_instructor'] ?? null,
            $validated['isactive'] ?? true,
            $validated['remark'] ?? null
        ]);

        return redirect()->route('Lessons.index')
            ->with('success', 'Driving lesson updated successfully');
    }

    /**
     * Remove the specified driving lesson from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::statement('CALL DeleteDrivingLesson(?)', [$id]);
        
        return redirect()->route('Lessons.index')
            ->with('success', 'Driving lesson deleted successfully');
    }

    /**
     * Get driving lessons by student ID
     *
     * @param int $studentId
     * @return \Illuminate\Http\Response
     */
    public function getStudentLessons($studentId)
    {
        $lessons = DB::select('CALL GetDrivingLessonsByStudent(?)', [$studentId]);
        
        return view('lessons.student', compact('lessons', 'studentId'));
    }

    /**
     * Get driving lessons by instructor ID and date range
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getInstructorLessons(Request $request)
    {
        $instructorId = $request->input('instructor_id');
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d', strtotime('+7 days')));

        $lessons = DB::select('CALL GetDrivingLessonsByInstructor(?, ?, ?)', [
            $instructorId, $startDate, $endDate
        ]);
        
        $instructors = Instructor::where('isactive', true)->get();
        
        return view('lessons.instructor', compact('lessons', 'instructors', 'instructorId', 'startDate', 'endDate'));
    }
    
    /**
     * Get driving lessons by car ID and date range
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCarLessons(Request $request)
    {
        $carId = $request->input('car_id');
        $startDate = $request->input('start_date', date('Y-m-d'));
        $endDate = $request->input('end_date', date('Y-m-d', strtotime('+7 days')));

        $lessons = DB::select('CALL GetDrivingLessonsByCar(?, ?, ?)', [
            $carId, $startDate, $endDate
        ]);
        
        $cars = Car::where('isactive', true)->get();
        
        return view('lessons.car', compact('lessons', 'cars', 'carId', 'startDate', 'endDate'));
    }

    /**
     * Display the lessons for the current student.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function studentLessons()
    {
        // Get the current authenticated student's ID
        $studentId = Auth::user()->student->id;
        $studentId = Auth::user()->student->id;
        
        // Fetch lessons for this student using stored procedure
        $allLessons = collect(DB::select('CALL GetDrivingLessonsByStudent(?)', [$studentId]));
        
        // Calculate totals for stats
        $totalLessons = $allLessons->count();
        $plannedLessons = $allLessons->where('lesson_status', 'Planned')->count();
        $completedLessons = $allLessons->where('lesson_status', 'Completed')->count();
        $canceledLessons = $allLessons->where('lesson_status', 'Canceled')->count();
        
        // Get the next upcoming lesson if any
        $nextLesson = $allLessons->where('lesson_status', 'Planned')
                                ->sortBy('start_date')
                                ->first();
        
        // Paginate the collection manually
        $page = request()->get('page', 1);
        $perPage = 10;
        $currentPageItems = $allLessons->sortByDesc('start_date')->slice(($page - 1) * $perPage, $perPage)->values();
        
        // Create a paginator manually
        $lessons = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $totalLessons,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('lessons.student-index', compact(
            'lessons', 
            'totalLessons', 
            'plannedLessons', 
            'completedLessons', 
            'canceledLessons',
            'nextLesson'
        ));
    }

    /**
     * Display details of a specific lesson for a student
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function studentShowLesson($id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
        
        if (!$lesson) {
            return redirect()->route('student.lessons')->with('error', 'Lesson not found');
        }
        
        // Check if this lesson belongs to the current student
        $studentId = Auth::user()->student->id;
        if ($lesson->student_id != $studentId) {
            return redirect()->route('student.lessons')->with('error', 'Unauthorized access');
        }
        
        return view('lessons.student-show', compact('lesson'));
    }

    /**
     * Display form for student to add feedback for a lesson
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function studentFeedbackForm($id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
        
        if (!$lesson) {
            return redirect()->route('student.lessons')->with('error', 'Lesson not found');
        }
        
        // Check if this lesson belongs to the current student
        $studentId = Auth::user()->student->id;
        if ($lesson->student_id != $studentId) {
            return redirect()->route('student.lessons')->with('error', 'Unauthorized access');
        }
        
        return view('lessons.student-feedback', compact('lesson'));
    }

    /**
     * Store student feedback for a lesson
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function studentStoreFeedback(Request $request, $id)
    {
        $validated = $request->validate([
            'student_comment' => 'required|string|max:1000',
        ]);
        
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
        
        if (!$lesson) {
            return redirect()->route('student.lessons')->with('error', 'Lesson not found');
        }
        
        // Check if this lesson belongs to the current student
        $studentId = \Illuminate\Support\Facades\Auth::user()->student->id;
        if ($lesson->student_id != $studentId) {
            return redirect()->route('student.lessons')->with('error', 'Unauthorized access');
        }
        
        // Update the lesson with student feedback
        DB::statement('CALL UpdateLessonStudentComment(?, ?)', [
            $id,
            $validated['student_comment']
        ]);
        
        return redirect()->route('student.lessons.show', $id)
            ->with('success', 'Your feedback has been saved successfully');
    }

    /**
     * Display a listing of driving lessons for a specific student from an instructor's perspective.
     *
     * @param int $studentId
     * @return \Illuminate\Http\Response
     */
    public function instructorStudentLessons($studentId)
    {
        // Get the current instructor's ID
        $instructor = Auth::user()->instructor;
        
        if (!$instructor) {
            return redirect()->route('instructor.dashboard')
                ->with('error', 'You do not have instructor privileges');
        }
        
        // First check if this student is assigned to this instructor
        $student = DB::table('students')
            ->join('registrations', 'students.id', '=', 'registrations.student_id')
            ->join('driving_lessons', 'registrations.id', '=', 'driving_lessons.registration_id')
            ->where('driving_lessons.instructor_id', $instructor->id)
            ->where('students.id', $studentId)
            ->select('students.*', 'registrations.id as registration_id')
            ->first();
        
        if (!$student) {
            return redirect()->route('instructor.students')
                ->with('error', 'This student is not assigned to you or does not exist');
        }
        
        // Fetch all lessons for this student using stored procedure
        $allLessons = collect(DB::select('CALL GetDrivingLessonsByStudent(?)', [$studentId]));
        
        // Filter lessons to only those assigned to this instructor
        $allLessons = $allLessons->filter(function($lesson) use ($instructor) {
            return $lesson->instructor_id == $instructor->id;
        });
        
        // Calculate totals for stats
        $totalLessons = $allLessons->count();
        $plannedLessons = $allLessons->where('lesson_status', 'Planned')->count();
        $completedLessons = $allLessons->where('lesson_status', 'Completed')->count();
        $canceledLessons = $allLessons->where('lesson_status', 'Canceled')->count();
        
        // Get the next upcoming lesson if any
        $nextLesson = $allLessons->where('lesson_status', 'Planned')
                                ->sortBy('start_date')
                                ->first();
        
        // Get student details
        $studentDetails = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('students.id', $studentId)
            ->select('students.*', 'users.firstname', 'users.infix', 'users.lastname', 'users.email')
            ->first();
        
        // Paginate the collection manually
        $page = request()->get('page', 1);
        $perPage = 10;
        $currentPageItems = $allLessons->sortByDesc('start_date')->slice(($page - 1) * $perPage, $perPage)->values();
        
        // Create a paginator manually
        $lessons = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $totalLessons,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('lessons.instructor-student', compact(
            'lessons', 
            'studentDetails',
            'totalLessons', 
            'plannedLessons', 
            'completedLessons', 
            'canceledLessons',
            'nextLesson'
        ));
    }

    /**
     * Display a listing of driving lessons for the instructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function instructorLessons()
    {
        try {
            // Get the current instructor's ID
            $instructor = Auth::user()->instructor;
            
            if (!$instructor) {
                return redirect()->route('dashboard')
                    ->with('error', 'You do not have instructor privileges');
            }
            
            // Default date range is current week
            $startDate = request('start_date', now()->startOfWeek()->format('Y-m-d'));
            $endDate = request('end_date', now()->endOfWeek()->format('Y-m-d'));
            
            // Fetch lessons for this instructor using stored procedure
            $allLessons = collect(DB::select('CALL GetDrivingLessonsByInstructor(?, ?, ?)', [
                $instructor->id, $startDate, $endDate
            ]));
            
            // Calculate totals for stats
            $totalLessons = $allLessons->count();
            $plannedLessons = $allLessons->where('lesson_status', 'Planned')->count();
            $completedLessons = $allLessons->where('lesson_status', 'Completed')->count();
            $canceledLessons = $allLessons->where('lesson_status', 'Canceled')->count();
            
            // Get the next upcoming lesson if any
            $nextLesson = $allLessons->where('lesson_status', 'Planned')
                                    ->sortBy('start_date')
                                    ->first();
            
            // Paginate the collection manually
            $page = request()->get('page', 1);
            $perPage = 10;
            $currentPageItems = $allLessons->sortBy('start_date')->slice(($page - 1) * $perPage, $perPage)->values();
            
            // Create a paginator manually
            $lessons = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentPageItems,
                $totalLessons,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            
            return view('lessons.instructor-index', compact(
                'lessons', 
                'totalLessons', 
                'plannedLessons', 
                'completedLessons', 
                'canceledLessons',
                'nextLesson',
                'startDate',
                'endDate'
            ));
        } catch (\Exception $e) {
            // Fallback in case of error
            return redirect()->route('dashboard')
                ->with('error', 'Error loading instructor lessons: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new driving lesson specifically for an instructor.
     *
     * @return \Illuminate\Http\Response
     */
    public function instructorCreateLesson()
    {
        // Get the current instructor's ID
        $instructor = Auth::user()->instructor;
        
        if (!$instructor) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have instructor privileges');
        }
        
        // Get the instructor's assigned students via registrations
        $registrations = Registration::where('isactive', true)->get();
        
        // Only get cars that are active
        $cars = Car::where('isactive', true)->get();
        
        return view('lessons.instructor-create', compact('registrations', 'cars', 'instructor'));
    }

    /**
     * Store a newly created driving lesson by an instructor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function instructorStoreLesson(Request $request)
    {
        // Get the current instructor's ID
        $instructor = Auth::user()->instructor;
        
        if (!$instructor) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have instructor privileges');
        }
        
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
            'goal' => 'nullable|string',
            'remark' => 'nullable|string'
        ]);

        // Format start and end datetime
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'] . ':00';
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'] . ':00';
        
        // Call the stored procedure to insert a new driving lesson
        DB::statement('CALL InsertDrivingLesson(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $validated['registration_id'],
            $instructor->id, // Use the instructor's ID automatically
            $validated['car_id'],
            $startDateTime,
            $endDateTime,
            'Planned', // Default status for new lessons
            $validated['goal'] ?? null,
            null, // No student comment initially
            null, // No instructor comment initially
            $validated['remark'] ?? null
        ]);

        return redirect()->route('instructor.lessons')
            ->with('success', 'Driving lesson scheduled successfully');
    }

    /**
     * Display lesson details for an instructor
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function instructorShowLesson($id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
        
        if (!$lesson) {
            return redirect()->route('instructor.lessons')->with('error', 'Lesson not found');
        }
        
        // Check if this lesson belongs to the current instructor
        $instructorId = Auth::user()->instructor->id;
        if ($lesson->instructor_id != $instructorId) {
            return redirect()->route('instructor.lessons')->with('error', 'Unauthorized access');
        }
        
        return view('lessons.instructor-show', compact('lesson'));
    }

    /**
     * Show the form for editing a lesson by an instructor
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function instructorEditLesson($id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
        
        if (!$lesson) {
            return redirect()->route('instructor.lessons')->with('error', 'Lesson not found');
        }
        
        // Check if this lesson belongs to the current instructor
        $instructorId = Auth::user()->instructor->id;
        if ($lesson->instructor_id != $instructorId) {
            return redirect()->route('instructor.lessons')->with('error', 'Unauthorized access');
        }
        
        $cars = Car::where('isactive', true)->get();
        
        return view('lessons.instructor-edit', compact('lesson', 'cars'));
    }

    /**
     * Update a lesson by an instructor
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function instructorUpdateLesson(Request $request, $id)
    {
        $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
        
        if (!$lesson) {
            return redirect()->route('instructor.lessons')->with('error', 'Lesson not found');
        }
        
        // Check if this lesson belongs to the current instructor
        $instructorId = Auth::user()->instructor->id;
        if ($lesson->instructor_id != $instructorId) {
            return redirect()->route('instructor.lessons')->with('error', 'Unauthorized access');
        }
        
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
            'lesson_status' => 'required|in:Planned,Completed,Canceled',
            'goal' => 'nullable|string',
            'commentary_instructor' => 'nullable|string',
            'remark' => 'nullable|string'
        ]);
        
        // Format start and end datetime
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'] . ':00';
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'] . ':00';
        
        // Call the stored procedure to update the driving lesson
        DB::statement('CALL UpdateDrivingLesson(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            $id,
            $lesson->registration_id,  // Keep the original registration
            $instructorId,             // Keep the original instructor
            $validated['car_id'],
            $startDateTime,
            $endDateTime,
            $validated['lesson_status'],
            $validated['goal'] ?? null,
            $lesson->student_comment,  // Keep student comment unchanged
            $validated['commentary_instructor'] ?? null,
            true,                      // Keep lesson active
            $validated['remark'] ?? null
        ]);

        return redirect()->route('instructor.lessons')
            ->with('success', 'Lesson updated successfully');
    }
}
