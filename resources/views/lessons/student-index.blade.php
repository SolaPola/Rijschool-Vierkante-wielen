<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Driving Lessons - Rijschool Vierkante Wielen</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .bg-navy-50 { background-color: #f0f4f8; }
        .bg-navy-100 { background-color: #d8e2f3; }
        .bg-navy-600 { background-color: #1e40af; }
        .bg-navy-700 { background-color: #1e3a8a; }
        .text-navy-600 { color: #1e40af; }
        .text-navy-700 { color: #1e3a8a; }
        .text-navy-800 { color: #1e3570; }
        .text-navy-900 { color: #172554; }
        .hover\:bg-navy-50:hover { background-color: #f0f4f8; }
        .hover\:bg-navy-700:hover { background-color: #1e3a8a; }
        .hover\:text-navy-700:hover { color: #1e3a8a; }
        .hover\:text-navy-800:hover { color: #1e3570; }
        .focus\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="bg-navy-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold">Rijschool Vierkante Wielen</h1>
            <div class="flex items-center space-x-4">
                <button class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-user mr-2"></i>Profile
                </button>
                <button class="text-white hover:text-yellow-300">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
            <nav class="space-y-1">
                <a href="{{ route('student.dashboard') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('student.lessons') }}" class="block px-4 py-3 rounded-lg bg-navy-600 text-white font-medium">
                    <i class="fas fa-calendar-alt mr-3"></i>My Lessons
                </a>
                <a href="{{ route('student.progress') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-chart-line mr-3"></i>My Progress
                </a>
                <a href="{{ route('student.profile') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-user-cog mr-3"></i>My Profile
                </a>
            </nav>
        </div>
        
        <!-- Content Area -->
        <div class="flex-1">
            <!-- Page header -->
            <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-navy-800">My Driving Lessons</h2>
                <!-- Optional button to request a new lesson could go here -->
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Upcoming</p>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ $plannedLessons }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Completed</p>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ $completedLessons }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-800 mr-4">
                            <i class="fas fa-times-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Canceled</p>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ $canceledLessons }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Alerts -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Upcoming Lesson Alert if applicable -->
            @if(isset($nextLesson) && $nextLesson)
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded shadow-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">Your next lesson is on {{ date('l, F j', strtotime($nextLesson->start_date)) }} at {{ date('H:i', strtotime($nextLesson->start_date)) }} with instructor {{ $nextLesson->instructor_name }}.</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Lessons Table Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                    <h3 class="font-medium text-navy-800">My Lesson Schedule</h3>
                </div>
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-navy-700 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-white">Date</th>
                                <th class="px-6 py-3 text-white">Time</th>
                                <th class="px-6 py-3 text-white">Instructor</th>
                                <th class="px-6 py-3 text-white">Car</th>
                                <th class="px-6 py-3 text-white">Goal</th>
                                <th class="px-6 py-3 text-white">Status</th>
                                <th class="px-6 py-3 text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($lessons as $lesson)
                            <tr class="hover:bg-navy-50">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ date('d/m/Y', strtotime($lesson->start_date)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ date('H:i', strtotime($lesson->start_date)) }} - {{ date('H:i', strtotime($lesson->end_date)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">{{ $lesson->instructor_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $lesson->brand }} {{ $lesson->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $lesson->goal ?? 'Not specified' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($lesson->lesson_status == 'Planned')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Upcoming</span>
                                    @elseif ($lesson->lesson_status == 'Completed')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                    @elseif ($lesson->lesson_status == 'Canceled')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('student.lessons.show', $lesson->id) }}" 
                                        class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> Details
                                        </a>
                                        
                                        @if($lesson->lesson_status == 'Planned')
                                            <a href="{{ route('student.lessons.feedback', $lesson->id) }}" 
                                            class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                <i class="fas fa-comment mr-1"></i> Add Notes
                                            </a>
                                        @endif
                                        
                                        @if($lesson->lesson_status == 'Completed')
                                            <a href="{{ route('student.lessons.feedback', $lesson->id) }}" 
                                            class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                <i class="fas fa-star mr-1"></i> Feedback
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 mb-2">You don't have any lessons scheduled yet</p>
                                        <p class="text-navy-600">Please contact your instructor to schedule a lesson</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-3 flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($lessons->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $lessons->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-navy-700 bg-white border border-gray-300 rounded-md hover:bg-navy-50">
                                    Previous
                                </a>
                            @endif
                            
                            @if ($lessons->hasMorePages())
                                <a href="{{ $lessons->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-navy-700 bg-white border border-gray-300 rounded-md hover:bg-navy-50">
                                    Next
                                </a>
                            @else
                                <span class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Next
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $lessons->firstItem() ?? 0 }}</span>
                                    to
                                    <span class="font-medium">{{ $lessons->lastItem() ?? 0 }}</span>
                                    of
                                    <span class="font-medium">{{ $lessons->total() }}</span>
                                    results
                                </p>
                            </div>
                            <div>
                                {{ $lessons->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
