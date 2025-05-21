<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons Dashboard - Rijschool Vierkante Wielen</title>
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
                <a href="{{ route('Cars.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-car mr-3"></i>Cars
                </a>
                <a href="{{ route('Students.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-users mr-3"></i>Students
                </a>
                <a href="{{ route('Lessons.index') }}" class="block px-4 py-3 rounded-lg bg-navy-600 text-white font-medium">
                    <i class="fas fa-calendar-alt mr-3"></i>Lessons
                </a>
                <a href="{{ route('Reports.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-chart-bar mr-3"></i>Reports
                </a>
                <a href="{{ route('settings.profile') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-cog mr-3"></i>Settings
                </a>
            </nav>
        </div>
        
        <!-- Content Area -->
        <div class="flex-1">
            <!-- Page header -->
            <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-navy-800">Lessons Management</h2>
                <a href="{{ route('Lessons.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-plus mr-2"></i>Schedule New Lesson
                </a>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-navy-600">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Total Lessons</p>
                            <p class="text-2xl font-bold text-navy-800">{{ count($lessons) }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Planned</p>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ $lessons->where('lesson_status', 'Planned')->count() }}
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
                                {{ $lessons->where('lesson_status', 'Completed')->count() }}
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
                                {{ $lessons->where('lesson_status', 'Canceled')->count() }}
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
            
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Lessons Table Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                    <h3 class="font-medium text-navy-800">Lessons Schedule</h3>
                </div>
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-navy-700 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-white">ID</th>
                                <th class="px-6 py-3 text-white">Student</th>
                                <th class="px-6 py-3 text-white">Instructor</th>
                                <th class="px-6 py-3 text-white">Car</th>
                                <th class="px-6 py-3 text-white">Start Time</th>
                                <th class="px-6 py-3 text-white">End Time</th>
                                <th class="px-6 py-3 text-white">Status</th>
                                <th class="px-6 py-3 text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($lessons as $lesson)
                            <tr class="hover:bg-navy-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $lesson->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">{{ $lesson->student_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $lesson->instructor_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $lesson->brand }} {{ $lesson->model }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ date('d/m/Y H:i', strtotime($lesson->start_datetime)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                    {{ date('d/m/Y H:i', strtotime($lesson->end_datetime)) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($lesson->lesson_status == 'Planned')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                    @elseif ($lesson->lesson_status == 'Completed')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                    @elseif ($lesson->lesson_status == 'Canceled')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('Lessons.show', $lesson->id) }}" 
                                        class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                        
                                        <a href="{{ route('Lessons.edit', $lesson->id) }}" 
                                        class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('Lessons.destroy', $lesson->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center"
                                                    onclick="return confirm('Are you sure you want to delete this lesson?')">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 mb-2">No lessons scheduled</p>
                                        <a href="{{ route('Lessons.create') }}" class="text-navy-600 hover:text-navy-800 font-medium">Schedule your first lesson</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="border-t border-gray-200">
                    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">
                        <span class="text-sm text-gray-700">
                            Showing <span class="font-medium text-navy-800">1-{{ count($lessons) }}</span> of 
                            <span class="font-medium text-navy-800">{{ count($lessons) }}</span>
                        </span>
                        <ul class="inline-flex items-stretch -space-x-px">
                            <li>
                                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-navy-600 bg-white rounded-l-lg border border-gray-300 hover:bg-navy-50">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 py-2 text-navy-600 bg-navy-50 border border-gray-300">1</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 text-navy-600 bg-white rounded-r-lg border border-gray-300 hover:bg-navy-50">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
