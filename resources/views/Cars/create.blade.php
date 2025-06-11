@extends('layouts.main')

@section('title', 'Create New Car - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Add New Car</h2>
        <a href="{{ route('Cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Back to Cars
        </a>
    </div>
    
    <!-- Alerts -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500"></i></div>
                <div class="ml-3">
                    <p class="font-medium">Please correct the following errors:</p>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Car Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Car Details</h3>
        </div>
        
        <form action="{{ route('Cars.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand <span class="text-red-600">*</span></label>
                    <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5" 
                           placeholder="e.g. Toyota">
                </div>
                
                <!-- Type/Model -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type/Model <span class="text-red-600">*</span></label>
                    <input type="text" id="type" name="type" value="{{ old('type') }}" required 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5" 
                           placeholder="e.g. Corolla">
                </div>
                
                <!-- License Plate -->
                <div>
                    <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-1">License Plate <span class="text-red-600">*</span></label>
                    <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" required 
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5" 
                           placeholder="e.g. AB-123-CD">
                </div>
                
                <!-- Fuel Type -->
                <div>
                    <label for="fuel" class="block text-sm font-medium text-gray-700 mb-1">Fuel Type <span class="text-red-600">*</span></label>
                    <select id="fuel" name="fuel" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5">
                        <option value="">Select fuel type</option>
                        <option value="petrol" {{ old('fuel') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                        <option value="diesel" {{ old('fuel') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="electric" {{ old('fuel') == 'electric' ? 'selected' : '' }}>Electric</option>
                        <option value="hybrid" {{ old('fuel') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>
            
            <!-- Remarks -->
            <div class="mt-6">
                <label for="remark" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea id="remark" name="remark" rows="3"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-500 focus:border-navy-500 block w-full p-2.5"
                          placeholder="Any additional notes or remarks">{{ old('remark') }}</textarea>
            </div>
            
            <!-- Active Status -->
            <div class="mt-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="isactive" checked
                           class="rounded border-gray-300 text-navy-600 shadow-sm focus:border-navy-300 focus:ring focus:ring-navy-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Mark as active (available for lessons)</span>
                </label>
            </div>
            
            <!-- Form Actions -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('Cars.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancel
                </a>
                <button type="submit" class="bg-navy-600 hover:bg-navy-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Create Car
                </button>
            </div>
        </form>
    </div>
@endsection
