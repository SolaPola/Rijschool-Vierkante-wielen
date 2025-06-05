@extends('layouts.main')

@section('title', 'Cars Overview - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Available Cars</h2>
    </div>
    
    <!-- Search and filter controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('Instructor.Cars.index') }}" class="space-y-4">
            <!-- Quick Search -->
            <div class="flex gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Quick Search</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Search by brand, type, license plate..." 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5 pl-10">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Basic Filters -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    <select id="brand" name="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="fuel" class="block text-sm font-medium text-gray-700 mb-1">Fuel Type</label>
                    <select id="fuel" name="fuel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                        <option value="">All Fuel Types</option>
                        @foreach($fuelTypes as $fuel)
                            <option value="{{ $fuel }}" {{ request('fuel') == $fuel ? 'selected' : '' }}>{{ ucfirst($fuel) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Filter Actions -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-navy-600 text-white rounded-lg hover:bg-navy-700">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('Instructor.Cars.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>
    
    <!-- Filter applied notification -->
    @if(request('search') || request('brand') || request('fuel'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex">
                    <div class="flex-shrink-0"><i class="fas fa-filter text-yellow-500"></i></div>
                    <div class="ml-3">
                        <p class="font-medium">
                            Filters applied: 
                            @if(request('search'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Search: "{{ request('search') }}"</span>
                            @endif
                            @if(request('brand'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Brand: {{ request('brand') }}</span>
                            @endif
                            @if(request('fuel'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Fuel: {{ ucfirst(request('fuel')) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('Instructor.Cars.index') }}" class="text-yellow-700 hover:text-yellow-900">
                    <i class="fas fa-times-circle"></i> Clear Filters
                </a>
            </div>
        </div>
    @endif
    
    <!-- Cars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($cars as $car)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-navy-700 text-white px-4 py-2 font-medium">
                    {{ $car->brand }} {{ $car->type }}
                </div>
                <div class="p-4">
                    <div class="mb-4 flex justify-center">
                        <div class="bg-gray-100 rounded-lg p-6 inline-block">
                            <i class="fas fa-car text-6xl text-navy-600"></i>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">License Plate:</span>
                            <span class="font-medium">{{ $car->license_plate }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fuel Type:</span>
                            <span class="font-medium">{{ ucfirst($car->fuel) }}</span>
                        </div>
                        @if($car->remark)
                            <div class="mt-3">
                                <span class="text-gray-600 block mb-1">Remarks:</span>
                                <p class="text-sm bg-gray-50 p-2 rounded">{{ $car->remark }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('Instructor.Cars.show', $car->id) }}" class="block w-full bg-navy-600 hover:bg-navy-700 text-white py-2 px-3 rounded-md text-center">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-lg shadow-md p-8 text-center">
                <div class="flex flex-col items-center">
                    <i class="fas fa-car text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-2">No cars found</p>
                    <p class="text-sm text-gray-400">Try adjusting your search criteria</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-6">
        {{ $cars->appends(request()->query())->links() }}
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
