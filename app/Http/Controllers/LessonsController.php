<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Fetch all driving lessons using the stored procedure
        $lessonsArray = DB::select('CALL GetAllDrivingLessons()');
        $lessons = collect($lessonsArray); // Convert array to collection
        return view('lessons.index', compact('lessons'));
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
}
