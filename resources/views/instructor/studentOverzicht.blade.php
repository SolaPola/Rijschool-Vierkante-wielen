@extends('layouts.main')

@section('title', 'Student Overview - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Student Overview</h2>
        <a href="{{ route('students.create') }}"
            class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Add New Student
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-navy-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Total Students</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Passed Exams</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $passedExams }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Active Packages</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $activePackages }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Upcoming Exams</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $upcomingExams }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search Section -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between">
            <div class="flex flex-col md:flex-row gap-4">
                <div>
                    <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status-filter"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="completed">Completed</option>
                        <option value="on-hold">On Hold</option>
                    </select>
                </div>
                <div>
                    <label for="package-filter" class="block text-sm font-medium text-gray-700 mb-1">Package</label>
                    <select id="package-filter"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                        <option value="">All Packages</option>
                        <option value="starter">Starter (10 Lessons)</option>
                        <option value="standard">Standard (20 Lessons)</option>
                        <option value="comprehensive">Comprehensive (30 Lessons)</option>
                        <option value="intensive">Intensive (40 Lessons)</option>
                    </select>
                </div>
            </div>
            <div class="flex-1 md:max-w-xs">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search"
                        class="pl-10 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5"
                        placeholder="Search students...">
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50 flex justify-between items-center">
            <h3 class="font-medium text-navy-800">All Students ({{ $totalStudents }})</h3>
            <div class="flex space-x-2">
                <button class="text-navy-600 hover:text-navy-800">
                    <i class="fas fa-filter"></i>
                </button>
                <button class="text-navy-600 hover:text-navy-800">
                    <i class="fas fa-download"></i>
                </button>
                <button class="text-navy-600 hover:text-navy-800">
                    <i class="fas fa-print"></i>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-navy-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-white">Student</th>
                        <th class="px-6 py-3 text-white">Contact</th>
                        <th class="px-6 py-3 text-white">Package</th>
                        <th class="px-6 py-3 text-white">Instructor</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-navy-100 flex items-center justify-center mr-3">
                                        <span class="text-xs font-medium text-navy-700">
                                            {{ strtoupper(substr($student['firstname'], 0, 1) . substr($student['lastname'], 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <span>{{ $student['firstname'] }} {{ $student['infix'] }}
                                            {{ $student['lastname'] }}</span>
                                        <p class="text-xs text-gray-500">
                                            ID: {{ $student['relation_number'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                <div>
                                    <div>{{ $student['email'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $student['phone'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                <span class="font-medium">{{ $student['package'] }}</span>
                                <div class="text-xs text-gray-500">{{ $student['start_date'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $student['instructor'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($student['status'] == 'active')
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                @elseif($student['status'] == 'completed')
                                    <span
                                        class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Completed</span>
                                @elseif($student['status'] == 'on-hold')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">On
                                        Hold</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">Unknown</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('students.edit', $student['id']) }}"
                                        class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <button type="button"
                                        data-student-id="{{ $student['id'] }}"
                                        data-student-name="{{ $student['firstname'] }} {{ $student['lastname'] }}"
                                        class="delete-btn bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                    <a href="{{ route('Lessons.student', $student['id']) }}"
                                        class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-calendar-alt mr-1"></i> Lessons
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-navy-700 mb-3">
                                        <i class="fas fa-search text-4xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No students found</h3>
                                    <p class="text-gray-500 mb-4">Search with a different name or try again
                                        later
                                    </p>
                                    <a href="{{ route('instructor.students') }}"
                                        class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700 inline-flex items-center">
                                        <i class="fas fa-sync-alt mr-2"></i> Refresh Results
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if (count($students) > 0)
            <div class="px-6 py-4 bg-white border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">1</span> to <span
                            class="font-medium">{{ count($students) }}</span> of <span
                            class="font-medium">{{ count($students) }}</span> results
                    </div>
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1 bg-navy-50 text-navy-700 rounded-md hover:bg-navy-100 disabled:opacity-50"
                            disabled>
                            Previous
                        </button>
                        <button class="px-3 py-1 bg-navy-600 text-white rounded-md hover:bg-navy-700">
                            1
                        </button>
                        <button
                            class="px-3 py-1 bg-navy-50 text-navy-700 rounded-md hover:bg-navy-100 disabled:opacity-50"
                            disabled>
                            Next
                        </button>
                    </div>
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
        // Simple filtering functionality
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('status-filter');
            const packageFilter = document.getElementById('package-filter');
            const searchInput = document.getElementById('search');
            const tableRows = document.querySelectorAll('tbody tr');
            const tableBody = document.querySelector('tbody');

            function applyFilters() {
                const statusValue = statusFilter.value.toLowerCase();
                const packageValue = packageFilter.value.toLowerCase();
                const searchValue = searchInput.value.toLowerCase();

                let visibleCount = 0;

                tableRows.forEach(row => {
                    if (row.querySelector('td[colspan="6"]')) {
                        // This is already the "no results" row
                        return;
                    }

                    const studentName = row.querySelector('td:first-child').textContent.toLowerCase();
                    const statusText = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                    const packageText = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                    const matchesStatus = !statusValue || statusText.includes(statusValue);
                    const matchesPackage = !packageValue || packageText.includes(packageValue);
                    const matchesSearch = !searchValue || studentName.includes(searchValue);

                    if (matchesStatus && matchesPackage && matchesSearch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Check if we need to show the "no results" message
                const noResultsRow = document.getElementById('no-results-row');

                if (visibleCount === 0 && !noResultsRow && tableRows.length > 0) {
                    // Create and insert a "no results from filter" row
                    const newRow = document.createElement('tr');
                    newRow.id = 'no-results-row';
                    newRow.innerHTML = `
                    <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-navy-700 mb-3">
                                <i class="fas fa-filter text-4xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-700 mb-1">No matching students</h3>
                            <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
                            <button onclick="resetFilters()" 
                                   class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700 inline-flex items-center">
                                <i class="fas fa-times mr-2"></i> Clear Filters
                            </button>
                        </div>
                    </td>
                `;
                    tableBody.appendChild(newRow);
                } else if (visibleCount > 0 && noResultsRow) {
                    // Remove the "no results" row if we have visible results again
                    noResultsRow.remove();
                }
            }

            // Function to reset all filters
            window.resetFilters = function() {
                statusFilter.value = '';
                packageFilter.value = '';
                searchInput.value = '';

                // Remove the "no results" row
                const noResultsRow = document.getElementById('no-results-row');
                if (noResultsRow) {
                    noResultsRow.remove();
                }

                // Show all rows except the original "no results" row
                tableRows.forEach(row => {
                    if (!row.querySelector('td[colspan="6"]')) {
                        row.style.display = '';
                    }
                });
            };

            statusFilter.addEventListener('change', applyFilters);
            packageFilter.addEventListener('change', applyFilters);
            searchInput.addEventListener('input', applyFilters);
        });
    </script>

    <script>
        // Delete functionality
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
                    const studentId = this.getAttribute('data-student-id');
                    const studentName = this.getAttribute('data-student-name');
                    
                    // Set the correct route with DELETE method
                    deleteForm.action = `/admin/students/${studentId}`;
                    confirmMessage.textContent = `Are you sure you want to delete ${studentName}?`;
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
