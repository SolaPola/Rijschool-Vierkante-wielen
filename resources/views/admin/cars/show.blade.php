@extends('layouts.main')

@section('title', 'Car Details - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Car Details</h2>
        <div class="flex space-x-2">
            <a href="{{ route('Admin.Cars.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Cars
            </a>
            <a href="{{ route('Admin.Cars.edit', $car->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <button type="button" onclick="openModal('delete-car-{{ $car->id }}')" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md inline-flex items-center">
                <i class="fas fa-trash mr-2"></i> Delete
            </button>
        </div>
    </div>
    
    <!-- Confirmation Modal -->
    <x-confirmation-modal
        id="delete-car-{{ $car->id }}"
        title="Bevestig verwijderen"
        message="Weet je zeker dat je deze lesauto ({{ $car->brand }} {{ $car->type }} - {{ $car->license_plate }}) wilt verwijderen?"
        action="{{ route('Admin.Cars.destroy', $car->id) }}"
        confirmText="Verwijderen"
        cancelText="Annuleren"
    />
    
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
    
    <!-- Car Details -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Car Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-4">Basic Details</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Brand:</span>
                            <span class="font-medium">{{ $car->brand }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Model:</span>
                            <span class="font-medium">{{ $car->type }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">License Plate:</span>
                            <span class="font-medium">{{ $car->license_plate }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Fuel Type:</span>
                            <span class="font-medium">{{ ucfirst($car->fuel) }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">
                                @if($car->isactive)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                @elseif(method_exists($car, 'isInMaintenance') && $car->isInMaintenance())
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">
                                        Maintenance until {{ $car->maintenance_until->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-4">Usage Statistics</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Upcoming Lessons:</span>
                            <span class="font-medium">{{ $upcomingLessonsCount ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Past Lessons:</span>
                            <span class="font-medium">{{ $pastLessonsCount ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Created On:</span>
                            <span class="font-medium">{{ $car->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium">{{ $car->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($car->remark)
            <div class="mt-6">
                <h4 class="text-lg font-semibold text-navy-800 mb-4">Remarks</h4>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p>{{ $car->remark }}</p>
                </div>
            </div>
            @endif
            
            @if(isset($car->maintenance_reason) && $car->maintenance_reason)
            <div class="mt-6">
                <h4 class="text-lg font-semibold text-navy-800 mb-4">Maintenance Information</h4>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="font-semibold mb-2">Reason for Maintenance:</p>
                    <p>{{ $car->maintenance_reason }}</p>
                    @if(isset($car->maintenance_until))
                    <p class="font-semibold mt-4 mb-2">Maintenance Until:</p>
                    <p>{{ $car->maintenance_until->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Maintenance Form (only show if car is active) -->
                @if($car->isactive)
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-4">Set Maintenance Mode</h4>
                    <form action="{{ route('Admin.Cars.maintenance', $car->id) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="maintenance_reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Maintenance</label>
                                <textarea id="maintenance_reason" name="maintenance_reason" rows="3" required
                                          class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5"
                                          placeholder="Enter reason for maintenance"></textarea>
                            </div>
                            
                            <div>
                                <label for="maintenance_until" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Until</label>
                                <input type="date" id="maintenance_until" name="maintenance_until" required
                                       class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5"
                                       min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-2 px-4 rounded-md inline-flex items-center">
                                <i class="fas fa-tools mr-2"></i> Set Maintenance Mode
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Cancel Future Lessons (only show if there are upcoming lessons) -->
                @if(isset($upcomingLessonsCount) && $upcomingLessonsCount > 0)
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-4">Cancel All Future Lessons</h4>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="mb-4">
                            This car has <strong>{{ $upcomingLessonsCount }}</strong> upcoming lessons. 
                            Cancelling all lessons will:
                        </p>
                        <ul class="list-disc list-inside mb-4 text-sm">
                            <li>Mark all future lessons as cancelled</li>
                            <li>Set the car to inactive status</li>
                            <li>Add a note to each lesson indicating why it was cancelled</li>
                        </ul>
                        
                        <form action="{{ route('Admin.Cars.cancelLessons', $car->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel all {{ $upcomingLessonsCount }} future lessons for this car? This action cannot be undone.');">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-md inline-flex items-center">
                                <i class="fas fa-ban mr-2"></i> Cancel All Lessons
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
