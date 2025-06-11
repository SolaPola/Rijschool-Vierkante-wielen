@extends('layouts.main')

@section('title', 'Car Details - Admin - Rijschool Vierkante Wielen')

@section('content')
    <!-- Breadcrumb navigation -->
    <nav class="mb-4 text-sm" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-navy-600">Dashboard</a>
                <svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('Admin.Cars.index') }}" class="text-gray-500 hover:text-navy-600">Cars</a>
                <svg class="fill-current w-3 h-3 mx-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="text-navy-600 font-medium">
                {{ $car->brand }} {{ $car->type }}
            </li>
        </ol>
    </nav>

    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Car Details</h2>
        <div class="flex space-x-2">
            <a href="{{ route('Admin.Cars.edit', $car->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('Admin.Cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back to Cars
            </a>
        </div>
    </div>

    <!-- Active/Inactive Alert -->
    @if(!$car->isactive)
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="font-bold">This car is currently unavailable</p>
                    @if($car->maintenance_reason)
                        <p>Reason: {{ $car->maintenance_reason }}</p>
                        @if($car->maintenance_until)
                            <p>Expected to be available after: {{ $car->maintenance_until->format('d/m/Y') }}</p>
                        @endif
                    @else
                        <p>This car cannot be used for lessons until it is activated.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Car Details Card -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Vehicle Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Brand</h4>
                        <p class="text-lg font-medium">{{ $car->brand }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Type/Model</h4>
                        <p class="text-lg font-medium">{{ $car->type }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">License Plate</h4>
                        <p class="text-lg font-medium">{{ $car->license_plate }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Fuel Type</h4>
                        <p class="text-lg font-medium">{{ ucfirst($car->fuel) }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Status</h4>
                        <p class="text-lg">
                            @if($car->isactive)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Available</span>
                            @elseif($car->isInMaintenance())
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">In Maintenance</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Unavailable</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Lesson Count</h4>
                        <p class="text-lg">
                            <span class="font-medium">{{ $upcomingLessonsCount }}</span> upcoming, 
                            <span class="font-medium">{{ $pastLessonsCount }}</span> completed
                        </p>
                    </div>
                </div>
            </div>
            
            @if($car->isInMaintenance())
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-500">Maintenance Information</h4>
                    <div class="mt-1 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="mb-2"><strong>Reason:</strong> {{ $car->maintenance_reason }}</p>
                        <p><strong>Expected completion:</strong> {{ $car->maintenance_until->format('d/m/Y') }}</p>
                    </div>
                </div>
            @endif
            
            @if($car->remark)
                <div class="mt-6">
                    <h4 class="text-sm font-medium text-gray-500">Remarks</h4>
                    <div class="mt-1 p-4 bg-gray-50 rounded-lg">
                        <p>{{ $car->remark }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Admin Actions Card -->
    <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Admin Actions</h3>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('Admin.Cars.edit', $car->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-edit mr-2"></i> Edit Details
                </a>
                
                @if($car->isactive)
                    <button type="button" onclick="document.getElementById('maintenance-modal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                        <i class="fas fa-tools mr-2"></i> Set Maintenance
                    </button>
                    
                    <form action="{{ route('Admin.Cars.update', $car->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="isactive" value="0">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all" onclick="return confirm('Are you sure you want to deactivate this car?')">
                            <i class="fas fa-ban mr-2"></i> Deactivate
                        </button>
                    </form>
                @else
                    <form action="{{ route('Admin.Cars.update', $car->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="isactive" value="1">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all">
                            <i class="fas fa-check-circle mr-2"></i> Activate
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Lessons Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Upcoming Lessons with this Car</h3>
        </div>
        <div class="p-6">
            @if(Route::has('Lessons.car'))
                <a href="{{ route('Lessons.car', ['car_id' => $car->id]) }}" class="inline-flex items-center px-4 py-2 bg-navy-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-calendar-alt mr-2"></i> View All Lessons
                </a>
            @else
                <p class="text-gray-500">Lesson scheduling is not available for this car.</p>
            @endif
        </div>
    </div>

    <!-- Maintenance Modal -->
    <div id="maintenance-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-navy-800">Set Car to Maintenance</h3>
                <button type="button" onclick="document.getElementById('maintenance-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('Admin.Cars.maintenance', $car->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="maintenance_reason" class="block text-sm font-medium text-gray-700 mb-1">Maintenance Reason <span class="text-red-600">*</span></label>
                    <input type="text" id="maintenance_reason" name="maintenance_reason" required 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5" 
                           placeholder="e.g. Engine repair">
                </div>
                
                <div class="mb-6">
                    <label for="maintenance_until" class="block text-sm font-medium text-gray-700 mb-1">Expected Until <span class="text-red-600">*</span></label>
                    <input type="date" id="maintenance_until" name="maintenance_until" required 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5"
                           min="{{ date('Y-m-d') }}">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('maintenance-modal').classList.add('hidden')" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-navy-800 rounded-lg hover:bg-yellow-600">
                        <i class="fas fa-tools mr-2"></i> Set Maintenance
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
