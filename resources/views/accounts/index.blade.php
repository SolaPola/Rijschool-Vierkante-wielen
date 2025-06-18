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
                                    
                                    <button type="button"
                                            data-user-name="{{ $user->firstname }} {{ $user->lastname }}"
                                            data-delete-url="{{ route('accounts.destroy', $user->id) }}"
                                            class="delete-btn bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
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

    <!-- Confirmation Popup -->
    <div id="delete-confirm-popup" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            
            <!-- Modal panel -->
            <div class="relative bg-white rounded-lg max-w-md w-full mx-auto shadow-lg">
                <div class="p-6">
                    <div class="mb-4 text-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-center">
                        Confirm Delete
                    </h3>
                    <p class="text-gray-600 mb-4 text-center" id="confirm-message">
                        Are you sure you want to delete this user?
                    </p>
                    <div class="flex justify-center space-x-4">
                        <button id="cancel-delete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <form id="delete-form" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Popup -->
    <div id="success-popup" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity"></div>
            
            <!-- Modal panel -->
            <div class="relative bg-white rounded-lg max-w-md w-full mx-auto shadow-lg">
                <div class="p-6">
                    <div class="mb-4 text-center">
                        <i class="fas fa-check-circle text-green-500 text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2 text-center" id="success-message">
                        The user has been deleted.
                    </h3>
                    <div class="flex justify-center mt-4">
                        <button id="close-success" class="px-4 py-2 bg-navy-600 text-white rounded hover:bg-navy-700">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteConfirmPopup = document.getElementById('delete-confirm-popup');
        const deleteForm = document.getElementById('delete-form');
        const cancelDeleteBtn = document.getElementById('cancel-delete');
        const confirmMessage = document.getElementById('confirm-message');
        const successPopup = document.getElementById('success-popup');
        const closeSuccessBtn = document.getElementById('close-success');
        const successMessage = document.getElementById('success-message');

        // Show confirm popup when delete button is clicked
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const deleteUrl = this.getAttribute('data-delete-url');
                const userName = this.getAttribute('data-user-name');
                
                // Set the form action directly
                deleteForm.action = deleteUrl;
                confirmMessage.textContent = `Are you sure you want to delete ${userName}?`;
                deleteConfirmPopup.classList.remove('hidden');
            });
        });

        // Hide confirm popup when cancel is clicked
        cancelDeleteBtn.addEventListener('click', function() {
            deleteConfirmPopup.classList.add('hidden');
        });

        // Handle form submission with Ajax
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const action = this.action;
            
            fetch(action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                deleteConfirmPopup.classList.add('hidden');
                successPopup.classList.remove('hidden');
                
                // Auto-hide success popup after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                successMessage.textContent = 'Error deleting user. Please try again.';
                successPopup.classList.remove('hidden');
            });
        });

        // Hide success popup when OK is clicked
        closeSuccessBtn.addEventListener('click', function() {
            successPopup.classList.add('hidden');
            window.location.reload();
        });

        // Close popups when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === deleteConfirmPopup || e.target === successPopup) {
                deleteConfirmPopup.classList.add('hidden');
                successPopup.classList.add('hidden');
            }
        });

        // Close popups when ESC key is pressed
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                deleteConfirmPopup.classList.add('hidden');
                successPopup.classList.add('hidden');
            }
        });
    });
</script>
@endsection
