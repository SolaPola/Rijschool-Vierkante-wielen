<x-app-layout>
    <x-slot name="title">Create New Lesson - Rijschool Vierkante Wielen</x-slot>
    
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Schedule a New Lesson</h2>
        <a href="{{ route('Lessons.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Lessons
        </a>
    </div>
    
    <!-- Alerts -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="font-bold">Please correct the following errors:</p>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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
    
    <!-- Lesson Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Lesson Details</h3>
        </div>
        
        <form action="{{ route('Lessons.store') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Debugging info for troubleshooting -->
            <div class="mb-4 p-3 bg-gray-100 rounded text-xs" style="display: none;">
                <p>Form will submit to: {{ route('Lessons.store') }}</p>
                <p>HTTP Method: POST</p>
                <p>CSRF Token is present: {{ csrf_token() ? 'Yes' : 'No' }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Selection -->
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <select id="student_id" name="student_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                        <option value="">Select a student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->user->firstname }} {{ $student->user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Instructor Selection -->
                <div>
                    <label for="instructor_id" class="block text-sm font-medium text-gray-700 mb-1">Instructor</label>
                    <select id="instructor_id" name="instructor_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                        <option value="">Select an instructor</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                {{ $instructor->user->firstname }} {{ $instructor->user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Vehicle Selection -->
                <div>
                    <label for="car_id" class="block text-sm font-medium text-gray-700 mb-1">Vehicle</label>
                    <select id="car_id" name="car_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                        <option value="">Select a vehicle</option>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->brand }} {{ $car->type }} ({{ $car->license_plate }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status Selection -->
                <div>
                    <label for="lesson_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="lesson_status" name="lesson_status" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                        <option value="scheduled" {{ old('lesson_status') == 'scheduled' ? 'selected' : '' }}>Planned</option>
                        <option value="confirmed" {{ old('lesson_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ old('lesson_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('lesson_status') == 'cancelled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') ?? date('Y-m-d') }}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                </div>
                
                <!-- Start Time -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') ?? '09:00' }}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                </div>
                
                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') ?? date('Y-m-d') }}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                </div>
                
                <!-- End Time -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') ?? '09:45' }}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                </div>
            </div>
            
            <!-- Goal -->
            <div class="mt-6">
                <label for="goal" class="block text-sm font-medium text-gray-700 mb-1">Lesson Goal</label>
                <input type="text" id="goal" name="goal" value="{{ old('goal') }}"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5"
                       placeholder="E.g. Highway driving practice">
            </div>
            
            <!-- Remark -->
            <div class="mt-6">
                <label for="remark" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea id="remark" name="remark" rows="3"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5"
                          placeholder="Any additional notes or remarks">{{ old('remark') }}</textarea>
            </div>
            
            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('Lessons.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    Cancel
                </a>
                <button type="submit" class="bg-navy-600 hover:bg-navy-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Schedule Lesson
                </button>
            </div>
        </form>
    </div>
    
    <x-slot name="scripts">
        <script>
            // Auto-populate end date when start date changes
            document.getElementById('start_date').addEventListener('change', function() {
                document.getElementById('end_date').value = this.value;
            });
            
            // Auto-calculate end time (45 minutes later) when start time changes
            document.getElementById('start_time').addEventListener('change', function() {
                const startTime = this.value;
                const [hours, minutes] = startTime.split(':').map(Number);
                
                let endMinutes = minutes + 45;
                let endHours = hours;
                
                if (endMinutes >= 60) {
                    endMinutes -= 60;
                    endHours += 1;
                }
                
                if (endHours >= 24) {
                    endHours -= 24;
                }
                
                const formattedEndHours = String(endHours).padStart(2, '0');
                const formattedEndMinutes = String(endMinutes).padStart(2, '0');
                
                document.getElementById('end_time').value = `${formattedEndHours}:${formattedEndMinutes}`;
            });
        </script>
    </x-slot>
</x-app-layout>
