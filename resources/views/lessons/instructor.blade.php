<x-layouts.app :title="$attributes->get('title')">
    <x-slot name="header">
        {{ $header ?? '' }}
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('Lessons.index') }}" class="inline-block mb-4 text-indigo-600 hover:text-indigo-900">
                            &larr; Back to All Lessons
                        </a>

                        <form method="GET" action="{{ route('Lessons.instructor') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-label for="instructor_id" :value="__('Select Instructor')" />
                                <select id="instructor_id" name="instructor_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select an instructor</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}" {{ $instructorId == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->user->name }} ({{ $instructor->number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-label for="start_date" :value="__('Start Date')" />
                                <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="$startDate ?? date('Y-m-d')" required />
                            </div>

                            <div>
                                <x-label for="end_date" :value="__('End Date')" />
                                <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="$endDate ?? date('Y-m-d', strtotime('+7 days'))" required />
                            </div>

                            <div class="md:col-span-3">
                                <x-button class="mt-2">
                                    {{ __('View Schedule') }}
                                </x-button>
                            </div>
                        </form>
                    </div>

                    @if(isset($instructorId) && $instructorId)
                        <h3 class="text-lg font-semibold mb-4">
                            Lessons for instructor: 
                            <span class="text-indigo-600">
                                {{ $instructors->firstWhere('id', $instructorId)->user->name ?? 'Instructor' }}
                            </span>
                            <span class="text-sm font-normal text-gray-500">
                                ({{ date('d-m-Y', strtotime($startDate)) }} to {{ date('d-m-Y', strtotime($endDate)) }})
                            </span>
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($lessons as $lesson)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ date('d-m-Y', strtotime($lesson->start_date)) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ date('H:i', strtotime($lesson->start_time)) }} - {{ date('H:i', strtotime($lesson->end_time)) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $lesson->student_name }}</div>
                                                <a href="{{ route('Lessons.student', $lesson->student_id) }}" class="text-xs text-indigo-600 hover:text-indigo-900">
                                                    View All Lessons
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $lesson->brand }} {{ $lesson->type }}</div>
                                                <div class="text-sm text-gray-500">{{ $lesson->license_plate }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $lesson->lesson_status == 'Completed' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $lesson->lesson_status == 'Planned' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $lesson->lesson_status == 'Canceled' ? 'bg-red-100 text-red-800' : '' }}">
                                                    {{ $lesson->lesson_status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('Lessons.show', $lesson->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                    <a href="{{ route('Lessons.edit', $lesson->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No lessons found for this instructor in the selected date range
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            Please select an instructor and date range to view their schedule
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
