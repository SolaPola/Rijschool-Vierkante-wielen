@extends('layouts.main')

@section('title', 'Instructor Dashboard - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Instructor Dashboard</h2>
        <div>
            <a href="{{ url('/Lessons/create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-plus mr-2"></i>New Lesson
            </a>
        </div>
    </div>
    
    <!-- Alerts -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-check-circle text-green-500"></i></div>
                <div class="ml-3"><p class="font-medium">{{ session('success') }}</p></div>
            </div>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500"></i></div>
                <div class="ml-3"><p class="font-medium">{{ session('error') }}</p></div>
            </div>
        </div>
    @endif
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-navy-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">My Students</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $studentCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Upcoming Lessons</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $upcomingLessonsCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                    <i class="fas fa-car text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Available Cars</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $carsCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Upcoming Lessons -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50 flex justify-between items-center">
            <h3 class="font-medium text-navy-800">Upcoming Lessons</h3>
            <a href="{{ url('/Lessons/instructors') }}" class="text-navy-600 hover:text-navy-800 text-sm">View All</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-navy-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-white">Student</th>
                        <th class="px-6 py-3 text-white">Date</th>
                        <th class="px-6 py-3 text-white">Time</th>
                        <th class="px-6 py-3 text-white">Car</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($upcomingLessons ?? [] as $lesson)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                @if(isset($lesson->student) && isset($lesson->student->user))
                                    {{ $lesson->student->user->firstname }} {{ $lesson->student->user->lastname }}
                                @elseif(isset($lesson->student_name))
                                    {{ $lesson->student_name }}
                                @else
                                    Unknown Student
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($lesson->start_time) ? date('d/m/Y', strtotime($lesson->start_time)) : 
                                   (isset($lesson->start_datetime) ? date('d/m/Y', strtotime($lesson->start_datetime)) : 'N/A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($lesson->start_time) ? date('H:i', strtotime($lesson->start_time)) : 
                                   (isset($lesson->start_datetime) ? date('H:i', strtotime($lesson->start_datetime)) : '') }}
                                -
                                {{ isset($lesson->end_time) ? date('H:i', strtotime($lesson->end_time)) : 
                                   (isset($lesson->end_datetime) ? date('H:i', strtotime($lesson->end_datetime)) : 'N/A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                @if(isset($lesson->car) && is_object($lesson->car))
                                    {{ $lesson->car->brand }} {{ $lesson->car->type }}
                                @elseif(isset($lesson->car_name))
                                    {{ $lesson->car_name }}
                                @else
                                    Unknown Car
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (isset($lesson->status) && $lesson->status == 'scheduled')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'confirmed')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Confirmed</span>
                                @elseif (isset($lesson->lesson_status) && $lesson->lesson_status == 'Planned')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                        {{ $lesson->status ?? ($lesson->lesson_status ?? 'Unknown') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('Lessons.show', $lesson->id) }}" 
                                   class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 mb-2">No upcoming lessons scheduled</p>
                                    <a href="{{ url('/Lessons/create') }}" class="text-navy-600 hover:text-navy-800 font-medium">Schedule your first lesson</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Recent Students -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50 flex justify-between items-center">
            <h3 class="font-medium text-navy-800">My Students</h3>
            <a href="{{ route('instructors.students') }}" class="text-navy-600 hover:text-navy-800 text-sm">View All</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-navy-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-white">Name</th>
                        <th class="px-6 py-3 text-white">Email</th>
                        <th class="px-6 py-3 text-white">Last Lesson</th>
                        <th class="px-6 py-3 text-white">Next Lesson</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($recentStudents ?? [] as $student)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                {{ $student->user->firstname ?? '' }} {{ $student->user->lastname ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $student->user->email ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($student->last_lesson) ? date('d/m/Y', strtotime($student->last_lesson)) : 'No lessons yet' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($student->next_lesson) ? date('d/m/Y', strtotime($student->next_lesson)) : 'None scheduled' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('Lessons.student', $student->id) }}" 
                                   class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                    <i class="fas fa-calendar-alt mr-1"></i> Lessons
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-graduate text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 mb-2">No students assigned yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
