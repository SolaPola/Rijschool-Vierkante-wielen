<x-app-layout>
    <x-slot name="title">Edit Lesson - Rijschool Vierkante Wielen</x-slot>
    
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Edit Lesson</h2>
        <a href="{{ route('Lessons.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Lessons
        </a>
    </div>
    
    <!-- Alerts -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500"></i></div>
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
        
        <form action="{{ route('Lessons.update', $lesson->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student info (read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        {{ $lesson->student->user->firstname }} {{ $lesson->student->user->lastname }}
                    </div>
                </div>
                
                <!-- Instructor info (read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instructor</label>
                    <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        {{ $lesson->instructor->user->firstname }} {{ $lesson->instructor->user->lastname }}
                    </div>
                </div>
                
                <!-- Car selection -->
                <div>
                    <label for="car_id" class="block text-sm font-medium text-gray-700 mb-1">Car</label>
                    <select id="car_id" name="car_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5 @error('car_id') border-red-500 @enderror">
                        <option value="">Select a car</option>
                        @foreach ($cars as $car)
                            <option value="{{ $car->id }}" {{ old('car_id', $lesson->vehicle_id) == $car->id ? 'selected' : '' }}>
                                {{ $car->brand }} {{ $car->type }} ({{ $car->license_plate }})
                            </option>
                        @endforeach
                    </select>
                    @error('car_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Lesson status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                        <option value="scheduled" {{ old('status', $lesson->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="confirmed" {{ old('status', $lesson->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ old('status', $lesson->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $lesson->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" id="start_date" name="start_date" 
                           value="{{ old('start_date', date('Y-m-d', strtotime($lesson->start_time))) }}"
                           required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5 @error('start_date') border-red-500 @enderror">
                    @error('start_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Start Time -->
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="time" id="start_time" name="start_time" 
                           value="{{ old('start_time', date('H:i', strtotime($lesson->start_time))) }}"
                           required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5 @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" id="end_date" name="end_date" 
                           value="{{ old('end_date', date('Y-m-d', strtotime($lesson->end_time))) }}"
                           required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5 @error('end_date') border-red-500 @enderror">
                    @error('end_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- End Time -->
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="time" id="end_time" name="end_time" 
                           value="{{ old('end_time', date('H:i', strtotime($lesson->end_time))) }}"
                           required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5 @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Lesson Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Lesson Title/Goal</label>
                    <input type="text" id="title" name="title" 
                           value="{{ old('title', $lesson->title) }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                </div>
                
                <!-- Lesson Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">{{ old('description', $lesson->description) }}</textarea>
                </div>
                
                <!-- Instructor Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Instructor Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">{{ old('notes', $lesson->notes) }}</textarea>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('Lessons.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    Cancel
                </a>
                <button type="submit" class="bg-navy-600 hover:bg-navy-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
    
    <!-- JavaScript for auto-updating end date when start date changes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            startDateInput.addEventListener('change', function() {
                endDateInput.value = this.value;
            });
        });
    </script>
</x-app-layout>
