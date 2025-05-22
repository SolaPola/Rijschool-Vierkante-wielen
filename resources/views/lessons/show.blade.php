<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Driving Lesson Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-lg font-semibold">Lesson #{{ $lesson->id }}</h3>
                        <div>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                {{ $lesson->lesson_status == 'Completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $lesson->lesson_status == 'Planned' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $lesson->lesson_status == 'Canceled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $lesson->lesson_status }}
                            </span>
                            @if(!$lesson->isactive)
                                <span class="ml-2 px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Student Information</h4>
                            <p><strong>Name:</strong> {{ $lesson->student_name }}</p>
                            <a href="{{ route('Lessons.student', $lesson->student_id) }}" class="text-indigo-600 hover:text-indigo-900 mt-2 inline-block">
                                View All Lessons for This Student
                            </a>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Instructor Information</h4>
                            <p><strong>Name:</strong> {{ $lesson->instructor_name }}</p>
                            <p><strong>Number:</strong> {{ $lesson->instructor_number }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Car Information</h4>
                            <p><strong>Brand & Type:</strong> {{ $lesson->brand }} {{ $lesson->type }}</p>
                            <p><strong>License Plate:</strong> {{ $lesson->license_plate }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-700 mb-2">Date & Time</h4>
                            <p><strong>Start:</strong> {{ date('d-m-Y', strtotime($lesson->start_date)) }} at {{ date('H:i', strtotime($lesson->start_time)) }}</p>
                            <p><strong>End:</strong> {{ date('d-m-Y', strtotime($lesson->end_date)) }} at {{ date('H:i', strtotime($lesson->end_time)) }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Lesson Goal</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p>{{ $lesson->goal ?? 'No goal specified' }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Student Comment</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p>{{ $lesson->student_comment ?? 'No student comment' }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <h4 class="font-medium text-gray-700 mb-2">Instructor Commentary</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p>{{ $lesson->commentary_instructor ?? 'No instructor commentary' }}</p>
                        </div>
                    </div>

                    @if($lesson->remark)
                        <div class="mt-6 border-t pt-4">
                            <h4 class="font-medium text-gray-700 mb-2">Remarks</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p>{{ $lesson->remark }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('Lessons.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Back to List
                        </a>
                        <a href="{{ route('Lessons.edit', $lesson->id) }}" class="ml-2 inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:border-yellow-900 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('Lessons.destroy', $lesson->id) }}" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this lesson?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
