<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructors Dashboard - Rijschool Vierkante Wielen</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .bg-navy-50 {
            background-color: #f0f4f8;
        }

        .bg-navy-100 {
            background-color: #d8e2f3;
        }

        .bg-navy-600 {
            background-color: #1e40af;
        }

        .bg-navy-700 {
            background-color: #1e3a8a;
        }

        .text-navy-600 {
            color: #1e40af;
        }

        .text-navy-700 {
            color: #1e3a8a;
        }

        .text-navy-800 {
            color: #1e3570;
        }

        .text-navy-900 {
            color: #172554;
        }

        .hover\:bg-navy-50:hover {
            background-color: #f0f4f8;
        }

        .hover\:bg-navy-700:hover {
            background-color: #1e3a8a;
        }

        .hover\:text-navy-700:hover {
            color: #1e3a8a;
        }

        .hover\:text-navy-800:hover {
            color: #1e3570;
        }

        .focus\:ring-offset-2:focus {
            --tw-ring-offset-width: 2px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="bg-navy-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold">Rijschool Vierkante Wielen</h1>
            <div class="flex items-center space-x-4">
                <button class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-user mr-2"></i>Profile
                </button>
                <button class="text-white hover:text-yellow-300">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
            <nav class="space-y-1">
                <a href="{{ route('instructors.index') }}"
                    class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-car mr-3"></i> Instructors
                </a>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1">
            <!-- Page header -->
            <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-navy-800">Instructors Management</h2>
                {{-- <a href="{{ route('instructors.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-plus mr-2"></i>Add New Instructor
                </a> --}}
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-navy-600">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                            <i class="fas fa-chalkboard-teacher text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Total Instructors</p>
                            <p class="text-2xl font-bold text-navy-800">{{ $totalInstructors }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                            <i class="fas fa-certificate text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Certified</p>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ $certifiedInstructors }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                            <i class="fas fa-user-check text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Active</p>
                            <p class="text-2xl font-bold text-navy-800">
                                {{ $activeInstructors }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-red-600">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Instructors Table Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                    <h3 class="font-medium text-navy-800">Instructors List</h3>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-navy-700 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-white">Name</th>
                                <th class="px-6 py-3 text-white">Email</th>
                                <th class="px-6 py-3 text-white">Username</th>
                                <th class="px-6 py-3 text-white">License</th>
                                <th class="px-6 py-3 text-white">Status</th>
                                <th class="px-6 py-3 text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($instructors as $instructor)
                                <tr class="hover:bg-navy-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                        {{ $instructor->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $instructor->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $instructor->username }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                        {{ $instructor->license_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($instructor->status == 'Active')
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                        @elseif ($instructor->status == 'On Leave')
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">On
                                                Leave</span>
                                        @elseif ($instructor->status == 'Inactive')
                                            <span
                                                class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            {{-- <a href="{{ route('instructors.show', $instructor->id) }}"
                                                class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                <i class="fas fa-eye mr-1"></i> View
                                            </a> --}}

                                            <a href="{{ route('instructors.edit', $instructor->id) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>

                                            <a href="{{ route('instructors.delete', $instructor->id) }}"
                                                class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-red-600">No instructors found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-3 flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            @if ($instructors->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Previous
                                </span>
                            @else
                                <a href="{{ $instructors->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-navy-700 bg-white border border-gray-300 rounded-md hover:bg-navy-50">
                                    Previous
                                </a>
                            @endif
                            @if ($instructors->hasMorePages())
                                <a href="{{ $instructors->nextPageUrl() }}"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-navy-700 bg-white border border-gray-300 rounded-md hover:bg-navy-50">
                                    Next
                                </a>
                            @else
                                <span
                                    class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                    Next
                                </span>
                            @endif
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $instructors->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $instructors->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $instructors->total() }}</span>
                                    results
                                </p>
                            </div>
                            <div>
                                <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($instructors->onFirstPage())
                                        <span
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left h-5 w-5"></i>
                                        </span>
                                    @else
                                        <a href="{{ $instructors->previousPageUrl() }}"
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-navy-500 hover:bg-navy-50">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left h-5 w-5"></i>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @for ($i = 1; $i <= $instructors->lastPage(); $i++)
                                        @if ($i == $instructors->currentPage())
                                            <span
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-navy-50 text-sm font-medium text-navy-700">{{ $i }}</span>
                                        @else
                                            <a href="{{ $instructors->url($i) }}"
                                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-navy-500 hover:bg-navy-50">{{ $i }}</a>
                                        @endif
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if ($instructors->hasMorePages())
                                        <a href="{{ $instructors->nextPageUrl() }}"
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-navy-500 hover:bg-navy-50">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right h-5 w-5"></i>
                                        </a>
                                    @else
                                        <span
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-default">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right h-5 w-5"></i>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
