@extends('layouts.main')

@section('title', 'Cars Management - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Cars Management</h2>
        <a href="{{ route('Admin.Cars.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Add New Car
        </a>
    </div>
    
    <!-- Search and filter controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('Admin.Cars.index') }}" class="space-y-4">
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
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            
            <!-- Advanced Filters -->
            <div x-data="{ showFilters: false }">
                <button type="button" @click="showFilters = !showFilters" class="text-navy-600 hover:text-navy-800 text-sm font-medium flex items-center">
                    <i class="fas fa-filter mr-1"></i> Advanced Filters
                    <i class="fas" :class="showFilters ? 'fa-chevron-up ml-1' : 'fa-chevron-down ml-1'"></i>
                </button>
                
                <div x-show="showFilters" class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-3">
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
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <input type="text" id="type" name="type" value="{{ request('type') }}" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                    </div>
                    
                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1">License Plate</label>
                        <input type="text" id="license_plate" name="license_plate" value="{{ request('license_plate') }}" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
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
            </div>
            
            <!-- Filter Actions -->
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-navy-600 text-white rounded-lg hover:bg-navy-700">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('Admin.Cars.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
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
    
    <!-- Filter applied notification -->
    @if(request('search') || request('brand') || request('type') || request('license_plate') || request('fuel') || (request('status') && request('status') != 'all'))
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
                            @if(request('type'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Type: {{ request('type') }}</span>
                            @endif
                            @if(request('license_plate'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">License: {{ request('license_plate') }}</span>
                            @endif
                            @if(request('fuel'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Fuel: {{ ucfirst(request('fuel')) }}</span>
                            @endif
                            @if(request('status') && request('status') != 'all')
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Status: {{ ucfirst(request('status')) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('Admin.Cars.index') }}" class="text-yellow-700 hover:text-yellow-900">
                    <i class="fas fa-times-circle"></i> Clear Filters
                </a>
            </div>
        </div>
    @endif
    
    <!-- Cars Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Vehicles</h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('Admin.Cars.index', array_merge(request()->query(), ['sort' => 'brand', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                Brand
                                @if(request('sort') == 'brand')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('Admin.Cars.index', array_merge(request()->query(), ['sort' => 'type', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                Type
                                @if(request('sort') == 'type')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('Admin.Cars.index', array_merge(request()->query(), ['sort' => 'license_plate', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                License Plate
                                @if(request('sort') == 'license_plate')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('Admin.Cars.index', array_merge(request()->query(), ['sort' => 'fuel', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center">
                                Fuel Type
                                @if(request('sort') == 'fuel')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cars as $car)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $car->brand }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $car->type }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $car->license_plate }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ ucfirst($car->fuel) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($car->isactive)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        Available
                                </span>
                                @elseif($car->isInMaintenance())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800" title="{{ $car->maintenance_reason }}">
                                        Maintenance until {{ $car->maintenance_until->format('d/m/Y') }}
                                </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                        Unavailable
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('Admin.Cars.show', $car->id) }}" class="text-navy-600 hover:text-navy-800">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('Admin.Cars.edit', $car) }}" class="text-yellow-600 hover:text-yellow-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" onclick="openDeleteModal('{{ $car->id }}', '{{ $car->brand }}', '{{ $car->type }}', '{{ $car->license_plate }}')" class="text-red-600 hover:text-red-800 cursor-pointer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <form id="delete-form-{{ $car->id }}" action="{{ route('Admin.Cars.destroy', $car) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="border-t border-gray-200">
            <div class="px-4 py-3 flex items-center justify-between">
                {{ $cars->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full relative z-10">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Bevestig verwijderen
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500" id="modal-description">
                            Weet je zeker dat je deze lesauto wilt verwijderen? Deze actie kan niet ongedaan gemaakt worden.
                        </p>
                        <p class="text-sm font-medium mt-2" id="car-details"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Ja, verwijderen
            </button>
            <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Annuleren
            </button>
        </div>
    </div>
</div>

<script>
    let currentCarId = null;

    function openDeleteModal(carId, brand, type, licensePlate) {
        currentCarId = carId;
        document.getElementById('car-details').textContent = `${brand} ${type} - Kenteken: ${licensePlate}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentCarId = null;
    }

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (currentCarId) {
            document.getElementById(`delete-form-${currentCarId}`).submit();
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeDeleteModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
</script>
@endsection