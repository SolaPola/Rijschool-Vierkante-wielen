@extends('layouts.main')

@section('title', 'Students Management - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Students Management</h2>
        <a href="{{ route('students.create') }}"
            class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Add New Student
        </a>
    </div>

    <!-- Status filter tabs -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow-md">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('students.index') }}"
                class="px-4 py-2 rounded-md {{ !request()->has('status') ? 'bg-navy-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All Students <span
                    class="ml-1 px-2 py-0.5 text-xs rounded-full {{ !request()->has('status') ? 'bg-white text-navy-800' : 'bg-gray-300 text-gray-700' }}">{{ $totalStudents ?? count($students) }}</span>
            </a>
            <a href="{{ route('students.index', ['status' => 'active']) }}"
                class="px-4 py-2 rounded-md {{ request()->get('status') == 'active' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Active <span
                    class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('status') == 'active' ? 'bg-white text-green-800' : 'bg-gray-300 text-gray-700' }}">{{ $activeStudents ?? 0 }}</span>
            </a>
            <a href="{{ route('students.index', ['status' => 'inactive']) }}"
                class="px-4 py-2 rounded-md {{ request()->get('status') == 'inactive' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Inactive <span
                    class="ml-1 px-2 py-0.5 text-xs rounded-full {{ request()->get('status') == 'inactive' ? 'bg-white text-red-800' : 'bg-gray-300 text-gray-700' }}">{{ $inactiveStudents ?? 0 }}</span>
            </a>
        </div>
    </div>

    <!-- Search and filter controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('students.index') }}" class="space-y-4">
            <!-- Preserve status filter if it exists -->
            @if (request()->has('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <!-- Search -->
            <div class="flex flex-wrap gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name/Email/Relation
                        Number</label>
                    <div class="relative">
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Search student..."
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
                    <a href="{{ route('students.index') }}"
                        class="px-4 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Filter applied notification -->
    @if (request('search') || (request('status') && request('status') != 'all'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex">
                    <div class="flex-shrink-0"><i class="fas fa-filter text-yellow-500"></i></div>
                    <div class="ml-3">
                        <p class="font-medium">
                            Filters applied:
                            @if (request('search'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Search:
                                    "{{ request('search') }}"</span>
                            @endif
                            @if (request('status') && request('status') != 'all')
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Status:
                                    {{ ucfirst(request('status')) }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('students.index') }}" class="text-yellow-700 hover:text-yellow-900">
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
                <div class="ml-3">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
            <div class="flex">
                <div class="flex-shrink-0"><i class="fas fa-exclamation-circle text-red-500"></i></div>
                <div class="ml-3">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Students Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">
                @if (request('status') == 'active')
                    Active Students
                @elseif(request('status') == 'inactive')
                    Inactive Students
                @else
                    All Students
                @endif
                @if (request('search'))
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
                        <th class="px-6 py-3 text-white">Relation Number</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                @if (isset($student->user) && is_object($student->user))
                                    {{ $student->user->firstname }}
                                    {{ isset($student->user->infix) && $student->user->infix ? $student->user->infix . ' ' : '' }}
                                    {{ $student->user->lastname }}
                                @else
                                    <span class="text-red-500">Unknown User</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                @if (isset($student->user) && is_object($student->user))
                                    {{ $student->user->email }}
                                @else
                                    <span class="text-red-500">No Email</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $student->relation_number ?? 'Not assigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($student->isactive)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    @if(isset($student->user) && is_object($student->user))
                                    <a href="{{ route('accounts.show', $student->user->id) }}" 
                                    class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    
                                    <a href="{{ route('accounts.edit', $student->user->id) }}" 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    @endif
                                    
                                    <button type="button"
                                        data-student-name="{{ isset($student->user) && is_object($student->user) ? $student->user->firstname . ' ' . $student->user->lastname : 'this student' }}"
                                        data-delete-url="{{ route('students.delete', $student->id) }}"
                                        class="delete-btn bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                    
                                    @if(Route::has('Lessons.student'))
                                    <a href="{{ route('Lessons.student', $student->id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-calendar-alt mr-1"></i> Lessons
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-graduate text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 mb-2">No students found</p>
                                    <a href="{{ route('accounts.create') }}?role=student"
                                        class="text-navy-600 hover:text-navy-800 font-medium">Add your first student</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if (isset($students) && method_exists($students, 'links'))
            <div class="border-t border-gray-200">
                <div class="px-4 py-3 flex items-center justify-between">
                    {{ $students->appends(request()->query())->links() }}
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
                        Are you sure you want to delete this student?
                    </p>
                    <div class="flex justify-center space-x-4">
                        <button id="cancel-delete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </button>
                        <form id="delete-form" method="POST" action="">
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
                        The student has been deleted.
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
                const studentName = this.getAttribute('data-student-name');
                
                confirmMessage.textContent = `Are you sure you want to delete ${studentName}?`;
                deleteForm.action = deleteUrl;
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
                successMessage.textContent = 'Error deleting student. Please try again.';
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
            if (e.target.classList.contains('fixed') && (e.target === deleteConfirmPopup || e.target === successPopup)) {
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
