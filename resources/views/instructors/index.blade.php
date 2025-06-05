@extends('layouts.main')

@section('title', 'Instructors Management - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Instructors Management</h2>
        <a href="{{ route('accounts.create') }}?role=instructor" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Add New Instructor
        </a>
    </div>
    
    <!-- Status filter tabs -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-md">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('instructors.index') }}" class="px-4 py-2 rounded-md {{ !request()->has('status') ? 'bg-navy-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All Instructors <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ !request()->has('status') ? 'bg-white text-navy-800' : 'bg-gray-300 text-gray-700' }}">{{ $totalInstructors ?? count($instructors) }}</span>
            </a>
            <a href="{{ route('instructors.index', ['status' => 'active']) }}" class="px-4 py-2 rounded-md {{ request()->get('status') == 'active' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('status') == 'active' ? 'bg-white text-green-800' : 'bg-gray-300 text-gray-700' }}">{{ $activeInstructors ?? 0 }}</span>
            </a>
            <a href="{{ route('instructors.index', ['status' => 'inactive']) }}" class="px-4 py-2 rounded-md {{ request()->get('status') == 'inactive' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Inactive <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('status') == 'inactive' ? 'bg-white text-red-800' : 'bg-gray-300 text-gray-700' }}">{{ $inactiveInstructors ?? 0 }}</span>
            </a>
        </div>
    </div>
    
    <!-- Search and filter controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('instructors.index') }}" class="space-y-4">
            <!-- Preserve status filter if it exists -->
            @if(request()->has('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <!-- Search -->
            <div class="flex flex-wrap gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name/Email/Instructor Number</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Search instructor..." 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5 pl-10">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Filter Actions -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2.5 bg-navy-600 text-white rounded-lg hover:bg-navy-700">
                        <i class="fas fa-filter mr-2"></i>Apply Filters
                    </button>
                    <a href="{{ route('instructors.index') }}" class="px-4 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Filter applied notification -->
    @if(request('search') || (request('status') && request('status') != 'all'))
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
                            @if(request('status') && request('status') != 'all')
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Status: {{ ucfirst(request('status')) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('instructors.index') }}" class="text-yellow-700 hover:text-yellow-900">
                    <i class="fas fa-times-circle"></i> Clear Filters
                </a>
            </div>
        </div>
    @endif
    
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
    
    <!-- Instructors Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">
                @if(request('status') == 'active')
                    Active Instructors
                @elseif(request('status') == 'inactive')
                    Inactive Instructors
                @else
                    All Instructors
                @endif
                @if(request('search'))
                    matching "{{ request('search') }}"
                @endif
            </h3>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-navy-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-white">Name</th>
                        <th class="px-6 py-3 text-white">Email</th>
                        <th class="px-6 py-3 text-white">Instructor Number</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($instructors as $instructor)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                @if(is_object($instructor))
                                    @if(isset($instructor->firstname) && isset($instructor->lastname))
                                        {{ $instructor->firstname }} 
                                        {{ isset($instructor->infix) && $instructor->infix ? $instructor->infix . ' ' : '' }}
                                        {{ $instructor->lastname }}
                                    @elseif(isset($instructor->user_firstname) && isset($instructor->user_lastname))
                                        {{ $instructor->user_firstname }} 
                                        {{ isset($instructor->user_infix) && $instructor->user_infix ? $instructor->user_infix . ' ' : '' }}
                                        {{ $instructor->user_lastname }}
                                    @elseif(isset($instructor->user) && is_object($instructor->user))
                                        {{ $instructor->user->firstname }} 
                                        {{ isset($instructor->user->infix) && $instructor->user->infix ? $instructor->user->infix . ' ' : '' }}
                                        {{ $instructor->user->lastname }}
                                    @else
                                        <span class="text-red-500">Unknown User</span>
                                    @endif
                                @else
                                    <span class="text-red-500">Invalid Instructor Data</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                @if(is_object($instructor))
                                    @if(isset($instructor->email))
                                        {{ $instructor->email }}
                                    @elseif(isset($instructor->user_email))
                                        {{ $instructor->user_email }}
                                    @elseif(isset($instructor->user) && is_object($instructor->user) && isset($instructor->user->email))
                                        {{ $instructor->user->email }}
                                    @else
                                        <span class="text-red-500">No Email</span>
                                    @endif
                                @else
                                    <span class="text-red-500">Invalid Instructor Data</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $instructor->number ?? 'Not assigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(isset($instructor->isactive) && $instructor->isactive)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @php
                                        $userId = null;
                                        if(isset($instructor->user_id)) {
                                            $userId = $instructor->user_id;
                                        } elseif(isset($instructor->user) && is_object($instructor->user) && isset($instructor->user->id)) {
                                            $userId = $instructor->user->id;
                                        }
                                    @endphp
                                    
                                    @if($userId)
                                    <a href="{{ route('accounts.show', $userId) }}" 
                                       class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    
                                    <a href="{{ route('accounts.edit', $userId) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    @endif
                                    
                                    <a href="{{ route('instructors.delete', $instructor->id) }}" 
                                       class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center"
                                       onclick="return confirm('Are you sure you want to delete this instructor?')">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-tie text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 mb-2">No instructors found</p>
                                    <a href="{{ route('accounts.create') }}?role=instructor" class="text-navy-600 hover:text-navy-800 font-medium">Add your first instructor</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(isset($instructors) && method_exists($instructors, 'links'))
        <div class="border-t border-gray-200">
            <div class="px-4 py-3 flex items-center justify-between">
                {{ $instructors->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
@endsection
