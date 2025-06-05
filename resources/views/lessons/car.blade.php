<x-app-layout>
    <x-slot name="title">Vehicle Lessons - Rijschool Vierkante Wielen</x-slot>
    
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">
            @if(isset($selectedCar))
                Lessons for {{ $selectedCar->brand }} {{ $selectedCar->type }} ({{ $selectedCar->license_plate }})
            @else
                Vehicle Lessons
            @endif
        </h2>
        
        <a href="{{ route('Cars.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Vehicles
        </a>
    </div>
    
    <!-- Car Selection & Date Filter -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('Lessons.car') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="car_id" class="block text-sm font-medium text-gray-700 mb-1">Vehicle</label>
                <select id="car_id" name="car_id" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                    @foreach ($cars as $car)
                        <option value="{{ $car->id }}" {{ $carId == $car->id ? 'selected' : '' }}>
                            {{ $car->brand }} {{ $car->type }} ({{ $car->license_plate }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
            </div>
            <div class="flex-1 min-w-[200px]">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2.5 bg-navy-600 text-white rounded-lg hover:bg-navy-700">
                    <i class="fas fa-filter mr-2"></i>Apply Filter
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
                    <p class="text-2xl font-bold text-navy-800">{{ $totalLessons ?? 0 }}</p>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $plannedLessons ?? 0 }}</p>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $completedLessons ?? 0 }}</p>
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
                    <p class="text-2xl font-bold text-navy-800">{{ $canceledLessons ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lessons Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Scheduled Lessons</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-navy-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-white">Student</th>
                        <th class="px-6 py-3 text-white">Instructor</th>
                        <th class="px-6 py-3 text-white">Start Time</th>
                        <th class="px-6 py-3 text-white">End Time</th>
                        <th class="px-6 py-3 text-white">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($lessons as $lesson)
                    <tr class="hover:bg-navy-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                            @if(isset($lesson->student->user))
                                {{ $lesson->student->user->firstname }} {{ $lesson->student->user->lastname }}
                            @else
                                Unknown Student
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            @if(isset($lesson->instructor->user))
                                {{ $lesson->instructor->user->firstname }} {{ $lesson->instructor->user->lastname }}
                            @else
                                Unknown Instructor
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $lesson->start_time ? date('d/m/Y H:i', strtotime($lesson->start_time)) : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                            {{ $lesson->end_time ? date('d/m/Y H:i', strtotime($lesson->end_time)) : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($lesson->status == 'scheduled')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                            @elseif ($lesson->status == 'completed')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                            @elseif ($lesson->status == 'cancelled')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $lesson->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 mb-2">No lessons scheduled for this vehicle</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
