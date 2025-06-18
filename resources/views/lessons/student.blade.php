@extends('layouts.main')

@section('title', 'Student Lessons - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <div>
            <h2 class="text-2xl font-bold text-navy-800">Lessons for {{ $student->user->firstname }} {{ $student->user->infix }} {{ $student->user->lastname }}</h2>
            <p class="text-gray-500">ID: {{ $student->relation_number }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('instructors.students') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-arrow-left mr-2"></i>Back to Students
            </a>
            <a href="{{ route('Lessons.create', ['student_id' => $student->id]) }}"
                class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-plus mr-2"></i>Add New Lesson
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-navy-600">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Total Lessons</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $totalLessons }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Completed</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $completedLessons }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Upcoming</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $upcomingLessons }}</p>
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
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
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
                        placeholder="Search lessons...">
                </div>
            </div>
        </div>
    </div>

    <!-- Lessons Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50 flex justify-between items-center">
            <h3 class="font-medium text-navy-800">All Lessons ({{ $totalLessons }})</h3>
            <div class="flex space-x-2">
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
                        <th class="px-6 py-3 text-white">Date & Time</th>
                        <th class="px-6 py-3 text-white">Duration</th>
                        <th class="px-6 py-3 text-white">Instructor</th>
                        <th class="px-6 py-3 text-white">Vehicle</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($formattedLessons as $lesson)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                <div>
                                    <div class="font-medium">{{ date('d M Y', strtotime($lesson['start_time'])) }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ date('H:i', strtotime($lesson['start_time'])) }} - {{ date('H:i', strtotime($lesson['end_time'])) }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $lesson['duration'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $lesson['instructor_name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ $lesson['car_info'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (strtolower($lesson['status']) == 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                @elseif(strtolower($lesson['status']) == 'scheduled' || strtolower($lesson['status']) == 'planned')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Scheduled</span>
                                @elseif(strtolower($lesson['status']) == 'cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Cancelled</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ ucfirst($lesson['status']) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('Lessons.edit', $lesson['id']) }}"
                                        class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    <a href="{{ route('Lessons.show', $lesson['id']) }}"
                                        class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="text-navy-700 mb-3">
                                        <i class="fas fa-calendar-alt text-4xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-700 mb-1">No lessons found</h3>
                                    <p class="text-gray-500 mb-4">This student doesn't have any scheduled lessons yet.</p>
                                    <a href="{{ route('Lessons.create', ['student_id' => $student->id]) }}"
                                        class="px-4 py-2 bg-navy-600 text-white rounded-md hover:bg-navy-700 inline-flex items-center">
                                        <i class="fas fa-plus mr-2"></i> Schedule First Lesson
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Simple filtering functionality
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        const searchInput = document.getElementById('search');
        const tableRows = document.querySelectorAll('tbody tr');
        const tableBody = document.querySelector('tbody');

        function applyFilters() {
            const statusValue = statusFilter.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();

            let visibleCount = 0;

            tableRows.forEach(row => {
                if (row.querySelector('td[colspan="6"]')) {
                    // This is already the "no results" row
                    return;
                }

                const statusText = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const instructorName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const dateTimeText = row.querySelector('td:first-child').textContent.toLowerCase();
                const vehicleText = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                // Search across multiple columns
                const searchableText = dateTimeText + ' ' + instructorName + ' ' + vehicleText;

                const matchesStatus = !statusValue || statusText.includes(statusValue);
                const matchesSearch = !searchValue || searchableText.includes(searchValue);

                if (matchesStatus && matchesSearch) {
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
                        <h3 class="text-lg font-medium text-gray-700 mb-1">No matching lessons</h3>
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
        searchInput.addEventListener('input', applyFilters);
    });
</script>
@endsection
