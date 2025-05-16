<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Dashboard - Rijschool Vierkante Wielen</title>
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
                <a href="{{ route('Cars.index') }}" class="block px-4 py-3 rounded-lg bg-navy-600 text-white font-medium">
                    <i class="fas fa-car mr-3"></i>Cars
                </a>
                <a href="{{ route('Students.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-users mr-3"></i>Students
                </a>
                <a href="{{ route('Lessons.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-calendar-alt mr-3"></i>Lessons
                </a>
                <a href="{{ route('Reports.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-chart-bar mr-3"></i>Reports
                </a>
                <a href="{{ route('settings.profile') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-cog mr-3"></i>Settings
                </a>
            </nav>
        </div>
        
        <!-- Content Area -->
        <div class="flex-1">
            <!-- Page header -->
            <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-navy-800">Cars Management</h2>
                <a href="{{ route('Cars.create') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-plus mr-2"></i>Add New Car
                </a>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-navy-600">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-navy-100 text-navy-800 mr-4">
                            <i class="fas fa-car text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Total Cars</p>
                            <p class="text-2xl font-bold text-navy-800">{{ $cars->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                            <i class="fas fa-wrench text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">In Maintenance</p>
                            <p class="text-2xl font-bold text-navy-800">2</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Available</p>
                            <p class="text-2xl font-bold text-navy-800">{{ $cars->count() - 2 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cars Table Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                    <h3 class="font-medium text-navy-800">Cars List</h3>
                </div>
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-navy-700 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-white">Brand</th>
                                <th class="px-6 py-3 text-white">Type</th>
                                <th class="px-6 py-3 text-white">License Plate</th>
                                <th class="px-6 py-3 text-white">Fuel</th>
                                <th class="px-6 py-3 text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($cars as $car)
                            <tr class="hover:bg-navy-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">{{$car->brand}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{$car->type}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{$car->license_plate}}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-navy-100 text-navy-800 rounded-full text-xs">{{$car->fuel}}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('Cars.edit', $car->id) }}" 
                                        class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('Cars.destroy', $car->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center"
                                                    onclick="return confirm('Are you sure you want to delete this car?')">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-car text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 mb-2">No cars found</p>
                                        <a href="{{ route('Cars.create') }}" class="text-navy-600 hover:text-navy-800 font-medium">Add your first car</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="border-t border-gray-200">
                    <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                        aria-label="Table navigation">
                        <span class="text-sm text-gray-700">
                            Showing <span class="font-medium text-navy-800">1-{{ $cars->count() }}</span> of 
                            <span class="font-medium text-navy-800">{{ $cars->count() }}</span>
                        </span>
                        <ul class="inline-flex items-stretch -space-x-px">
                            <li>
                                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-navy-600 bg-white rounded-l-lg border border-gray-300 hover:bg-navy-50">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center px-3 py-2 text-navy-600 bg-navy-50 border border-gray-300">1</a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 text-navy-600 bg-white rounded-r-lg border border-gray-300 hover:bg-navy-50">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
</html>