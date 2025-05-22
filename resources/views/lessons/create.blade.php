<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Driving Lesson') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('Lessons.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <!-- Registration Selection -->
                            <div>
                                <x-label for="registration_id" :value="__('Student Registration')" />
                                <select id="registration_id" name="registration_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select a registration</option>
                                    @foreach ($registrations as $registration)
                                        <option value="{{ $registration->id }}" {{ old('registration_id') == $registration->id ? 'selected' : '' }}>
                                            {{ $registration->student->name }} - Package: {{ $registration->package->name }} ({{ $registration->start_date }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('registration_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Instructor Selection -->
                            <div>
                                <x-label for="instructor_id" :value="__('Instructor')" />
                                <select id="instructor_id" name="instructor_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select an instructor</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->user->name }} ({{ $instructor->number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('instructor_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Car Selection -->
                            <div>
                                <x-label for="car_id" :value="__('Car')" />
                                <select id="car_id" name="car_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select a car</option>
                                    @foreach ($cars as $car)
                                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->brand }} {{ $car->type }} ({{ $car->license_plate }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('car_id')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lesson Status -->
                            <div>
                                <x-label for="lesson_status" :value="__('Lesson Status')" />
                                <select id="lesson_status" name="lesson_status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="Planned" {{ old('lesson_status') == 'Planned' ? 'selected' : '' }}>Planned</option>
                                    <option value="Completed" {{ old('lesson_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Canceled" {{ old('lesson_status') == 'Canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                                @error('lesson_status')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <x-label for="start_date" :value="__('Start Date')" />
                                <x-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                                @error('start_date')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Time -->
                            <div>
                                <x-label for="start_time" :value="__('Start Time')" />
                                <x-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                                @error('start_time')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Date -->
                            <div>
                                <x-label for="end_date" :value="__('End Date')" />
                                <x-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                                @error('end_date')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- End Time -->
                            <div>
                                <x-label for="end_time" :value="__('End Time')" />
                                <x-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time')" required />
                                @error('end_time')
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Goal -->
                        <div class="mt-4">
                            <x-label for="goal" :value="__('Lesson Goal')" />
                            <textarea id="goal" name="goal" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('goal') }}</textarea>
                            @error('goal')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Student Comment -->
                        <div class="mt-4">
                            <x-label for="student_comment" :value="__('Student Comment')" />
                            <textarea id="student_comment" name="student_comment" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('student_comment') }}</textarea>
                            @error('student_comment')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Instructor Commentary -->
                        <div class="mt-4">
                            <x-label for="commentary_instructor" :value="__('Instructor Commentary')" />
                            <textarea id="commentary_instructor" name="commentary_instructor" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('commentary_instructor') }}</textarea>
                            @error('commentary_instructor')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remark -->
                        <div class="mt-4">
                            <x-label for="remark" :value="__('Remarks')" />
                            <textarea id="remark" name="remark" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('remark') }}</textarea>
                            @error('remark')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('Lessons.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                Cancel
                            </a>
                            <x-button>
                                {{ __('Create Lesson') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
