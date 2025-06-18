@extends('layouts.main')

@section('title', 'Car Details - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Car Details</h2>
        <a href="{{ route('Instructor.Cars.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Cars
        </a>
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
    
    <!-- Car Details -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Car Information</h3>
        </div>
        
        <div class="p-6">
            <!-- Car Image -->
            <div class="flex justify-center mb-6">
                <div class="bg-gray-100 rounded-lg p-8 inline-block">
                    <i class="fas fa-car text-8xl text-navy-600"></i>
                </div>
            </div>
            
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
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-semibold text-navy-800 mb-4">Usage Information</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Your Upcoming Lessons:</span>
                            <span class="font-medium">{{ $upcomingLessonsCount ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-gray-600">Your Past Lessons:</span>
                            <span class="font-medium">{{ $pastLessonsCount ?? 0 }}</span>
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
            
            <!-- Lessons with this car button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('Lessons.car', ['car_id' => $car->id]) }}" class="bg-navy-600 hover:bg-navy-700 text-white py-2 px-4 rounded-md inline-flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i> View Lessons with this Car
                </a>
            </div>
        </div>
    </div>
@endsection
