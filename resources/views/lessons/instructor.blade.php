<x-app-layout>
    <x-slot name="title">My Lessons - Instructor Dashboard</x-slot>
    
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">My Lessons</h2>
        <a href="{{ route('Lessons.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Schedule New Lesson
        </a>
    </div>
    
    <!-- Date Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('Lessons.instructors') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate ?? now()->startOfWeek()->format('Y-m-d') }}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate ?? now()->endOfWeek()->format('Y-m-d') }}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2.5 bg-navy-600 text-white rounded-lg hover:bg-navy-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </form>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $totalLessons }}</p>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $plannedLessons }}</p>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $completedLessons }}</p>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $canceledLessons }}</p>
                </div>
            </div>
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
    
    <!-- Lessons Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">My Lessons Schedule</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-navy-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-white">Student</th>
                        <th class="px-6 py-3 text-white">Car</th>
                        <th class="px-6 py-3 text-white">Start Time</th>
                        <th class="px-6 py-3 text-white">End Time</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($paginatedLessons as $lesson)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                @if(isset($lesson->student) && is_object($lesson->student) && isset($lesson->student->user))
                                    {{ $lesson->student->user->firstname }} {{ $lesson->student->user->lastname }}
                                @elseif(isset($lesson->student_name))
                                    {{ $lesson->student_name }}
                                @else
                                    Unknown Student
                                @endif
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
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($lesson->start_time) ? date('d/m/Y H:i', strtotime($lesson->start_time)) : 
                                  (isset($lesson->start_datetime) ? date('d/m/Y H:i', strtotime($lesson->start_datetime)) : 'N/A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($lesson->end_time) ? date('d/m/Y H:i', strtotime($lesson->end_time)) : 
                                  (isset($lesson->end_datetime) ? date('d/m/Y H:i', strtotime($lesson->end_datetime)) : 'N/A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (isset($lesson->status) && $lesson->status == 'scheduled')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'confirmed')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Confirmed</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                                @elseif (isset($lesson->lesson_status) && $lesson->lesson_status == 'Planned')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                @elseif (isset($lesson->lesson_status) && $lesson->lesson_status == 'Completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                @elseif (isset($lesson->lesson_status) && $lesson->lesson_status == 'Canceled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                        {{ $lesson->status ?? ($lesson->lesson_status ?? 'Unknown') }}
                                    </span>
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center">
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
        @if(isset($paginatedLessons) && $paginatedLessons->count() > 0)
        <div class="border-t border-gray-200">
            <div class="px-4 py-3 flex items-center justify-between">
                {{ $paginatedLessons->links() }}
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
