<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Registration;
use App\Models\Student;
use App\Models\Lesson;
use Illuminate\Support\Facades\Log;


class LessonsController extends Controller
{
    /**
     * Display a listing of driving lessons.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Lesson::with(['instructor.user', 'student.user', 'car']);
            
            // Filter by status if provided
            if ($request->has('status') && $request->status != 'all') {
                $query->where('status', $request->status);
            }
            
            // Filter by search term (name or email)
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    // Search in student name or email
                    $q->whereHas('student.user', function($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                          ->orWhere('lastname', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    })
                    // Search in instructor name or email
                    ->orWhereHas('instructor.user', function($q) use ($search) {
                        $q->where('firstname', 'like', "%{$search}%")
                          ->orWhere('lastname', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    });
                });
            }
            
            // Order lessons by start time (latest first)
            $lessons = $query->orderBy('start_time', 'desc')->paginate(20);
            
            // Calculate totals for stats
            $totalLessons = Lesson::count();
            $plannedLessons = Lesson::where('status', 'scheduled')->count();
            $completedLessons = Lesson::where('status', 'completed')->count();
            $canceledLessons = Lesson::where('status', 'cancelled')->count();
            $confirmedLessons = Lesson::where('status', 'confirmed')->count();
            
            return view('lessons.index', compact(
                'lessons', 
                'totalLessons', 
                'plannedLessons', 
                'completedLessons', 
                'canceledLessons',
                'confirmedLessons'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading lessons: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new driving lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all active students
        $students = Student::where('isactive', true)
            ->with('user') // Eager load user data
            ->get();
        
        // Get all active instructors
        $instructors = Instructor::where('isactive', true)
            ->with('user') // Eager load user data
            ->get();
        
        // Get all active cars
        $cars = Car::where('isactive', true)->get();
        
        return view('lessons.create', compact('students', 'instructors', 'cars'));
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
            'student_id' => 'required|exists:students,id',
            'instructor_id' => 'required|exists:instructors,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'required|date_format:H:i',
            'lesson_status' => 'required|in:Planned,Completed,Canceled',
            'goal' => 'nullable|string',
            'remark' => 'nullable|string'
        ]);

        // Format start and end datetime
        $startDateTime = $validated['start_date'] . ' ' . $validated['start_time'] . ':00';
        $endDateTime = $validated['end_date'] . ' ' . $validated['end_time'] . ':00';
        
        // Create a new lesson
        $lesson = new Lesson();
        $lesson->student_id = $validated['student_id'];
        $lesson->instructor_id = $validated['instructor_id'];
        $lesson->car_id = $validated['car_id'];
        $lesson->start_datetime = $startDateTime;
        $lesson->end_datetime = $endDateTime;
        $lesson->lesson_status = $validated['lesson_status'];
        $lesson->goal = $validated['goal'] ?? null;
        $lesson->remark = $validated['remark'] ?? null;
        $lesson->isactive = true;
        $lesson->save();

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
        try {
            // Get the current instructor
            $instructor = Auth::user()->instructor;
            
            if (!$instructor) {
                return redirect()->route('dashboard')
                    ->with('error', 'You do not have instructor privileges');
            }
            
            // Get instructor ID from the logged-in user
            $instructorId = $instructor->id;
            
            // Default date range is current week
            $startDate = $request->input('start_date', now()->startOfWeek()->format('Y-m-d'));
            $endDate = $request->input('end_date', now()->endOfWeek()->format('Y-m-d'));
            
            // Fetch lessons for this instructor using stored procedure
            $lessons = DB::select('CALL GetDrivingLessonsByInstructor(?, ?, ?)', [
                $instructorId, $startDate, $endDate
            ]);
            
            // Convert to collection and paginate manually
            $allLessons = collect($lessons);
            $totalLessons = $allLessons->count();
            $plannedLessons = $allLessons->where('lesson_status', 'Planned')->count();
            $completedLessons = $allLessons->where('lesson_status', 'Completed')->count();
            $canceledLessons = $allLessons->where('lesson_status', 'Canceled')->count();
            
            // Paginate the collection
            $page = request()->get('page', 1);
            $perPage = 20;
            $currentPageItems = $allLessons->forPage($page, $perPage);
            
            $paginatedLessons = new \Illuminate\Pagination\LengthAwarePaginator(
                $currentPageItems,
                $totalLessons,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            
            return view('lessons.instructor', compact(
                'paginatedLessons', 
                'totalLessons',
                'plannedLessons',
                'completedLessons',
                'canceledLessons',
                'startDate',
                'endDate'
            ));
        }
        catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error loading instructor lessons: ' . $e->getMessage());
        }
    }
    
    /**
     * Get driving lessons by car ID and date range
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCarLessons(Request $request)
    {
        try {
            $carId = $request->input('car_id');
            if (!$carId) {
                // If no car ID is provided, get the first available car
                $car = Car::where('isactive', true)->first();
                if ($car) {
                    $carId = $car->id;
                } else {
                    return redirect()->back()->with('error', 'No active cars available');
                }
            }
            
            $startDate = $request->input('start_date', date('Y-m-d'));
            $endDate = $request->input('end_date', date('Y-m-d', strtotime('+7 days')));

            // Use the vehicle_id column instead of car_id
            $lessons = Lesson::where('vehicle_id', $carId)
                ->whereBetween('start_time', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->with(['instructor.user', 'student.user'])
                ->get();
            
            // Calculate statistics
            $totalLessons = $lessons->count();
            $plannedLessons = $lessons->where('status', 'scheduled')->count();
            $completedLessons = $lessons->where('status', 'completed')->count();
            $canceledLessons = $lessons->where('status', 'cancelled')->count();
            
            $cars = Car::where('isactive', true)->get();
            $selectedCar = Car::find($carId);
            
            return view('lessons.car', compact(
                'lessons', 
                'cars', 
                'selectedCar', 
                'carId', 
                'startDate', 
                'endDate',
                'totalLessons',
                'plannedLessons',
                'completedLessons',
                'canceledLessons'
            ));
        } catch (\Exception $e) {
            return redirect()->route('Cars.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the lessons for the current student.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function studentLessons()
    {
        try {
            // Get the current authenticated student's ID
            $student = Auth::user()->student;
            
            if (!$student) {
                return redirect()->route('dashboard')
                    ->with('error', 'Student profile not found. Please contact an administrator.');
            }
            
            $studentId = $student->id;
        
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
        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error loading student lessons: ' . $e->getMessage());
        }
    }

    /**
     * Display details of a specific lesson for a student
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function studentShowLesson($id)
    {
        try {
            $lesson = DB::select('CALL GetDrivingLessonById(?)', [$id])[0] ?? null;
            
            if (!$lesson) {
                return redirect()->route('student.lessons')->with('error', 'Lesson not found');
            }
            
            // Check if this lesson belongs to the current student
            $student = Auth::user()->student;
            
            if (!$student) {
                return redirect()->route('dashboard')
                    ->with('error', 'Student profile not found. Please contact an administrator.');
            }
            
            $studentId = $student->id;
            if ($lesson->student_id != $studentId) {
                return redirect()->route('student.lessons')->with('error', 'Unauthorized access');
            }
            
            return view('lessons.student-show', compact('lesson'));
        } catch (\Exception $e) {
            return redirect()->route('student.lessons')
                ->with('error', 'Error viewing lesson: ' . $e->getMessage());
        }
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
            // Get the current user
            $user = Auth::user();
            
            // Get instructor - check if it exists
            $instructor = null;
            
            // Check if the user object has an instructor relationship
            if (method_exists($user, 'instructor') && $user->instructor) {
                $instructor = $user->instructor;
            } else {
                // Alternatively, try to find the instructor record directly
                $instructor = Instructor::where('user_id', $user->id)->first();
            }
            
            // If no instructor found, notify and redirect
            if (!$instructor) {
                return redirect()->route('dashboard')
                    ->with('error', 'Instructor profile not found. Please contact an administrator.');
            }
            
            $instructorId = $instructor->id;
        
            // Default date range is current week
            $startDate = request('start_date', now()->startOfWeek()->format('Y-m-d'));
            $endDate = request('end_date', now()->endOfWeek()->format('Y-m-d'));
            
            // Use try-catch to handle potential errors with different database schemas
            try {
                // Try using the modern column names first
                $lessons = Lesson::where('instructor_id', $instructorId)
                    ->whereBetween('start_time', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->with(['student.user', 'car'])
                    ->orderBy('start_time')
                    ->get();
            } catch (\Exception $e) {
                try {
                    // If that fails, try with legacy column names
                    $lessons = Lesson::where('instructor_id', $instructorId)
                        ->whereBetween('start_datetime', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                        ->with(['student.user', 'car'])
                        ->orderBy('start_datetime')
                        ->get();
                } catch (\Exception $e2) {
                    // If both fail, create an empty collection
                    $lessons = collect([]);
                }
            }
            
            // Calculate statistics (safely)
            $totalLessons = $lessons->count();
            $plannedLessons = $lessons->where('status', 'scheduled')
                ->merge($lessons->where('lesson_status', 'Planned'))
                ->count();
            $completedLessons = $lessons->where('status', 'completed')
                ->merge($lessons->where('lesson_status', 'Completed'))
                ->count();
            $canceledLessons = $lessons->where('status', 'cancelled')
                ->merge($lessons->where('lesson_status', 'Canceled'))
                ->count();
            
            // Paginate results
            $perPage = 10;
            $page = request()->get('page', 1);
            $paginatedLessons = new \Illuminate\Pagination\LengthAwarePaginator(
                $lessons->forPage($page, $perPage),
                $totalLessons,
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
            
            return view('lessons.instructor', compact(
                'paginatedLessons',
                'totalLessons',
                'plannedLessons',
                'completedLessons',
                'canceledLessons',
                'startDate',
                'endDate'
            ));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in instructorLessons method: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->route('dashboard')
                ->with('error', 'Error loading instructor lessons. Please try again later or contact support.');
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
