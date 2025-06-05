<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\accounts\index.blade.php -->
@extends('layouts.main')

@section('title', 'User Accounts - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">User Accounts</h2>
        <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Add New User
        </a>
    </div>

    <!-- Role filter tabs -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-md">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('accounts.index') }}" class="px-4 py-2 rounded-md {{ !request()->has('role') ? 'bg-navy-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All Users <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ !request()->has('role') ? 'bg-white text-navy-800' : 'bg-gray-300 text-gray-700' }}">{{ $totalUsers ?? count($users) }}</span>
            </a>
            <a href="{{ route('accounts.index', ['role' => 'administrator']) }}" class="px-4 py-2 rounded-md {{ request()->get('role') == 'administrator' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Administrators <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('role') == 'administrator' ? 'bg-white text-purple-800' : 'bg-gray-300 text-gray-700' }}">{{ $adminCount ?? $users->where('role.name', 'administrator')->count() }}</span>
            </a>
            <a href="{{ route('accounts.index', ['role' => 'instructor']) }}" class="px-4 py-2 rounded-md {{ request()->get('role') == 'instructor' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Instructors <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('role') == 'instructor' ? 'bg-white text-blue-800' : 'bg-gray-300 text-gray-700' }}">{{ $instructorCount ?? $users->where('role.name', 'instructor')->count() }}</span>
            </a>
            <a href="{{ route('accounts.index', ['role' => 'student']) }}" class="px-4 py-2 rounded-md {{ request()->get('role') == 'student' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Students <span class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('role') == 'student' ? 'bg-white text-green-800' : 'bg-gray-300 text-gray-700' }}">{{ $studentCount ?? $users->where('role.name', 'student')->count() }}</span>
            </a>
        </div>
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

    <!-- Users Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">
                @if(request()->has('role'))
                    {{ ucfirst(request()->get('role')) }} Users
                @else
                    All Users
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
                        <th class="px-6 py-3 text-white">Username</th>
                        <th class="px-6 py-3 text-white">Role</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($users as $user)
                        @if(!request()->has('role') || (isset($user->role) && $user->role->name == request()->get('role')))
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                {{ $user->firstname }} {{ $user->infix }} {{ $user->lastname }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->role)
                                    @if ($user->role->name == 'administrator')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Admin</span>
                                    @elseif ($user->role->name == 'instructor')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Instructor</span>
                                    @elseif ($user->role->name == 'student')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Student</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $user->role->name }}</span>
                                    @endif
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">No Role</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('accounts.show', $user->id) }}" 
                                    class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    
                                    <a href="{{ route('accounts.edit', $user->id) }}" 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('accounts.destroy', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 mb-2">No users found</p>
                                    <a href="{{ route('accounts.create') }}" class="text-navy-600 hover:text-navy-800 font-medium">Add your first user</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if(method_exists($users, 'links'))
        <div class="border-t border-gray-200">
            <div class="px-4 py-3 flex items-center justify-between">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>
@endsection
