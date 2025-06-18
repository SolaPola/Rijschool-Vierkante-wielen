@extends('layouts.main')

@section('title', 'View User - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">User Details</h2>
        <div class="flex space-x-2">
            <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Back to Users
            </a>
            <a href="{{ route('accounts.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
        </div>
    </div>

    <!-- User Details Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">Personal Information</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-navy-800 font-medium">{{ $user->firstname }} {{ $user->infix }} {{ $user->lastname }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Birth Date</label>
                        <p class="text-navy-800">{{ date('F j, Y', strtotime($user->birthdate)) }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                        <p>
                            @if ($user->role)
                                @if ($user->role->name == 'administrator')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Administrator</span>
                                @elseif ($user->role->name == 'instructor')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Instructor</span>
                                @elseif ($user->role->name == 'student')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Student</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ ucfirst($user->role->name) }}</span>
                                @endif
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">No Role</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                        <p class="text-navy-800">{{ $user->username }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-navy-800">{{ $user->email }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                        <p>
                            @if($user->is_active)
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information for specific roles -->
    @if($user->role && $user->role->name == 'student')
        @if($user->student)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                <h3 class="font-medium text-navy-800">Student Information</h3>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-1">Relation Number</label>
                    <p class="text-navy-800">{{ $user->student->relation_number }}</p>
                </div>
                
                <!-- Additional student information here -->
            </div>
        </div>
        @endif
    @elseif($user->role && $user->role->name == 'instructor')
        @if($user->instructor)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                <h3 class="font-medium text-navy-800">Instructor Information</h3>
            </div>
            <div class="p-6">
                <!-- Instructor-specific information here -->
            </div>
        </div>
        @endif
    @endif
@endsection
