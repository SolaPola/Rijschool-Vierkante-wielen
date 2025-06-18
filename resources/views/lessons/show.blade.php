<x-app-layout>
    <x-slot name="title">Lesson Details - Rijschool Vierkante Wielen</x-slot>
    
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Lesson Details</h2>
        <a href="{{ route('Lessons.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Lessons
        </a>
    </div>
    
    <!-- Alerts -->
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500"></i></div>
                <div class="ml-3"><p class="font-medium">{{ session('error') }}</p></div>
            </div>
        </div>
    @endif
    
    <!-- Lesson Details Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Lesson #{{ $lesson->id }}</h3>
        </div>
        
        <div class="p-6">
            <!-- Status Badge -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <span class="text-gray-700 font-medium">Status: </span>
                    @if ($lesson->lesson_status == 'scheduled' || $lesson->lesson_status == 'Planned')
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Scheduled</span>
                    @elseif ($lesson->lesson_status == 'confirmed' || $lesson->lesson_status == 'Confirmed')
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">Confirmed</span>
                    @elseif ($lesson->lesson_status == 'completed' || $lesson->lesson_status == 'Completed')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Completed</span>
                    @elseif ($lesson->lesson_status == 'cancelled' || $lesson->lesson_status == 'Canceled')
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Cancelled</span>
                    @else
                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">{{ $lesson->lesson_status }}</span>
                    @endif
                </div>
                <div>
                    <a href="{{ route('Lessons.edit', $lesson->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-2 px-4 rounded-md inline-flex items-center">
                        <i class="fas fa-edit mr-2"></i> Edit Lesson
                    </a>
                </div>
            </div>
            
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">Student</h4>
                    <p class="text-gray-700">{{ $lesson->student_name ?? 'Unknown Student' }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">Instructor</h4>
                    <p class="text-gray-700">{{ $lesson->instructor_name ?? 'Unknown Instructor' }}</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">Vehicle</h4>
                    <p class="text-gray-700">{{ $lesson->brand ?? '' }} {{ $lesson->model ?? '' }}</p>
                </div>
            </div>
            
            <!-- Time Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">Start Time</h4>
                    <p class="text-gray-700">
                        {{ isset($lesson->start_datetime) ? date('F j, Y \a\t g:i A', strtotime($lesson->start_datetime)) : 'N/A' }}
                    </p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">End Time</h4>
                    <p class="text-gray-700">
                        {{ isset($lesson->end_datetime) ? date('F j, Y \a\t g:i A', strtotime($lesson->end_datetime)) : 'N/A' }}
                    </p>
                </div>
            </div>
            
            <!-- Goal/Details -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-navy-800 mb-3">Lesson Goal</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $lesson->goal ?? 'No goal specified' }}</p>
                </div>
            </div>
            
            <!-- Comments Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">Student Comments</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $lesson->student_comment ?? 'No student comments' }}</p>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-3">Instructor Comments</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700">{{ $lesson->commentary_instructor ?? 'No instructor comments' }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Additional Remarks -->
            @if(isset($lesson->remark) && !empty($lesson->remark) && $lesson->remark != $lesson->student_comment)
            <div class="mt-6">
                <h4 class="text-lg font-semibold text-navy-800 mb-3">Additional Remarks</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">{{ $lesson->remark }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
