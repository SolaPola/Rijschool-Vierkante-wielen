<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons Dashboard - Rijschool Vierkante Wielen</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .bg-navy-50 { background-color: #f0f4f8; }
        .bg-navy-100 { background-color: #d8e2f3; }
        .bg-navy-600 { background-color: #1e40af; }
        .bg-navy-700 { background-color: #1e3a8a; }
        .text-navy-600 { color: #1e40af; }
        .text-navy-700 { color: #1e3a8a; }
        .text-navy-800 { color: #1e3570; }
        .text-navy-900 { color: #172554; }
        .hover\:bg-navy-50:hover { background-color: #f0f4f8; }
        .hover\:bg-navy-700:hover { background-color: #1e3a8a; }
        .hover\:text-navy-700:hover { color: #1e3a8a; }
        .hover\:text-navy-800:hover { color: #1e3570; }
        .focus\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }
    </style>
</head>
<body class="bg-gray-50">

           
        
        <!-- Content Area -->
        <div class="flex-1">
            <x-app-layout>
    <x-slot name="title">Lessons Management - Rijschool Vierkante Wielen</x-slot>
    
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Lessons Management</h2>
        <a href="{{ route('Lessons.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-plus mr-2"></i>Schedule New Lesson
        </a>
    </div>
    
    <!-- Filter controls -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('Lessons.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Status filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
                    <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <!-- Search filter -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search by Name/Email</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search name or email..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-navy-600 focus:border-navy-600 block w-full p-2.5">
            </div>
            
            <!-- Filter actions -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="px-4 py-2.5 bg-navy-600 text-white rounded-lg hover:bg-navy-700">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
                <a href="{{ route('Lessons.index') }}" class="px-4 py-2.5 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <a href="{{ route('Lessons.index') }}" class="bg-white rounded-lg shadow-md p-4 border-l-4 border-navy-600 hover:bg-navy-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Total</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $totalLessons }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('Lessons.index', ['status' => 'scheduled']) }}" class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500 hover:bg-blue-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Scheduled</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $plannedLessons }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('Lessons.index', ['status' => 'confirmed']) }}" class="bg-white rounded-lg shadow-md p-4 border-l-4 border-purple-500 hover:bg-purple-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-800 mr-4">
                    <i class="fas fa-thumbs-up text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Confirmed</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $confirmedLessons }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('Lessons.index', ['status' => 'completed']) }}" class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500 hover:bg-green-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Completed</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $completedLessons }}</p>
                </div>
            </div>
        </a>
        <a href="{{ route('Lessons.index', ['status' => 'cancelled']) }}" class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500 hover:bg-red-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-800 mr-4">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 uppercase">Cancelled</p>
                    <p class="text-2xl font-bold text-navy-800">{{ $canceledLessons }}</p>
                </div>
            </div>
        </a>
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
    @if(request('status') || request('search'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-md">
            <div class="flex justify-between items-center">
                <div class="flex">
                    <div class="flex-shrink-0"><i class="fas fa-filter text-yellow-500"></i></div>
                    <div class="ml-3">
                        <p class="font-medium">
                            Filters applied: 
                            @if(request('status') && request('status') != 'all')
                                <span class="px-2 py-1 bg-white rounded-full text-xs mr-2">Status: {{ ucfirst(request('status')) }}</span>
                            @endif
                            @if(request('search'))
                                <span class="px-2 py-1 bg-white rounded-full text-xs">Search: "{{ request('search') }}"</span>
                            @endif
                        </p>
                    </div>
                </div>
                <a href="{{ route('Lessons.index') }}" class="text-yellow-700 hover:text-yellow-900">
                    <i class="fas fa-times-circle"></i> Clear Filters
                </a>
            </div>
        </div>
    @endif
    
    <!-- Lessons Table Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
            <h3 class="font-medium text-navy-800">
                @if(request('status') && request('status') != 'all')
                    {{ ucfirst(request('status')) }} Lessons
                @else
                    All Lessons
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
                        <th class="px-6 py-3 text-white">Student</th>
                        <th class="px-6 py-3 text-white">Instructor</th>
                        <th class="px-6 py-3 text-white">Car</th>
                        <th class="px-6 py-3 text-white">Start Time</th>
                        <th class="px-6 py-3 text-white">End Time</th>
                        <th class="px-6 py-3 text-white">Status</th>
                        <th class="px-6 py-3 text-white">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($lessons as $lesson)
                        <tr class="hover:bg-navy-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                @if(isset($lesson->student) && isset($lesson->student->user))
                                    {{ $lesson->student->user->firstname }} {{ $lesson->student->user->lastname }}
                                @else
                                    Unknown Student
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                @if(isset($lesson->instructor) && isset($lesson->instructor->user))
                                    {{ $lesson->instructor->user->firstname }} {{ $lesson->instructor->user->lastname }}
                                @else
                                    Unknown Instructor
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                @if(isset($lesson->car))
                                    {{ $lesson->car->brand }} {{ $lesson->car->type }}
                                @else
                                    Unknown Car
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($lesson->start_time) ? date('d/m/Y H:i', strtotime($lesson->start_time)) : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                {{ isset($lesson->end_time) ? date('d/m/Y H:i', strtotime($lesson->end_time)) : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (isset($lesson->status) && $lesson->status == 'scheduled')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'confirmed')
                                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">Confirmed</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'completed')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                @elseif (isset($lesson->status) && $lesson->status == 'cancelled')
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                        {{ $lesson->status ?? 'Unknown' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('Lessons.show', $lesson->id) }}" 
                                    class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                    
                                    <a href="{{ route('Lessons.edit', $lesson->id) }}" 
                                    class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                    
                                    <button type="button" 
                                            onclick="openDeleteModal('{{ $lesson->id }}', '{{ isset($lesson->student->user) ? $lesson->student->user->firstname . ' ' . $lesson->student->user->lastname : 'Unknown Student' }}', '{{ isset($lesson->start_time) ? date('d/m/Y H:i', strtotime($lesson->start_time)) : 'Unknown Date' }}')"
                                            class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                        <i class="fas fa-trash mr-1"></i> Annuleren
                                    </button>
                                    
                                    <form id="delete-form-{{ $lesson->id }}" action="{{ route('Lessons.destroy', $lesson->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 mb-2">No lessons scheduled</p>
                                    <a href="{{ route('Lessons.create') }}" class="text-navy-600 hover:text-navy-800 font-medium">Schedule your first lesson</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="border-t border-gray-200">
            <div class="px-4 py-3 flex items-center justify-between">
                {{ $lessons->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
        </div>
    </div>

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
                        Bevestig annulering
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500" id="modal-description">
                            Weet je zeker dat je deze rijles wilt annuleren? Deze actie kan niet ongedaan gemaakt worden.
                        </p>
                        <p class="text-sm font-medium mt-2" id="lesson-details"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="button" id="confirmDelete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Ja, annuleren
            </button>
            <button type="button" onclick="closeDeleteModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Annuleren
            </button>
        </div>
    </div>
</div>

<script>
    let currentLessonId = null;

    function openDeleteModal(lessonId, studentName, lessonDate) {
        currentLessonId = lessonId;
        document.getElementById('lesson-details').textContent = `Student: ${studentName} - Datum: ${lessonDate}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        currentLessonId = null;
    }

    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (currentLessonId) {
            document.getElementById(`delete-form-${currentLessonId}`).submit();
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
</body>
</html>
