<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\admin\dashboard.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rijschool Vierkante Wielen</title>
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
                <span class="text-sm text-white">Welcome, {{ Auth::user()->firstname }}</span>
                <button class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 px-4 py-2 rounded-lg font-medium">
                    <i class="fas fa-user mr-2"></i>Profile
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:text-yellow-300">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg bg-navy-600 text-white font-medium">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('accounts.index') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-users mr-3"></i>Users
                </a>
                <a href="#" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-calendar-alt mr-3"></i>Lessons
                </a>
                <a href="#" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>Instructors
                </a>
                <a href="#" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-user-graduate mr-3"></i>Students
                </a>
                <a href="#" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-car mr-3"></i>Vehicles
                </a>
                <a href="#" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
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
                <h2 class="text-2xl font-bold text-navy-800">Administrator Dashboard</h2>
                <a href="#" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-plus mr-2"></i>Quick Actions
                </a>
            </div>
            
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
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                            <i class="fas fa-chalkboard-teacher text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Total Instructors</p>
                            <p class="text-2xl font-bold text-navy-800">{{ $totalInstructors }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                            <i class="fas fa-calendar-alt text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Scheduled Lessons</p>
                            <p class="text-2xl font-bold text-navy-800">{{ $scheduledLessons }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Exam Pass Rate</p>
                            <p class="text-2xl font-bold text-navy-800">{{ $passRate }}%</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content Sections -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                        <h3 class="font-medium text-navy-800">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('accounts.create') }}" class="flex flex-col items-center p-4 bg-navy-50 rounded-lg hover:bg-navy-100">
                                <i class="fas fa-user-plus text-navy-700 text-xl mb-2"></i>
                                <span class="text-sm font-medium text-navy-800">Add User</span>
                            </a>
                            <a href="#" class="flex flex-col items-center p-4 bg-navy-50 rounded-lg hover:bg-navy-100">
                                <i class="fas fa-calendar-plus text-navy-700 text-xl mb-2"></i>
                                <span class="text-sm font-medium text-navy-800">Schedule Lesson</span>
                            </a>
                            <a href="#" class="flex flex-col items-center p-4 bg-navy-50 rounded-lg hover:bg-navy-100">
                                <i class="fas fa-file-invoice text-navy-700 text-xl mb-2"></i>
                                <span class="text-sm font-medium text-navy-800">Create Invoice</span>
                            </a>
                            <a href="#" class="flex flex-col items-center p-4 bg-navy-50 rounded-lg hover:bg-navy-100">
                                <i class="fas fa-chart-line text-navy-700 text-xl mb-2"></i>
                                <span class="text-sm font-medium text-navy-800">Generate Report</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                        <h3 class="font-medium text-navy-800">Recent Activity</h3>
                    </div>
                    <div class="p-4">
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">New student registered</p>
                                        <p class="text-xs text-gray-500">30 minutes ago</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-calendar-check text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Lesson scheduled</p>
                                        <p class="text-xs text-gray-500">2 hours ago</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-money-bill-wave text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Payment received</p>
                                        <p class="text-xs text-gray-500">5 hours ago</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-purple-100 p-2 rounded-full mr-3">
                                        <i class="fas fa-trophy text-purple-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Exam passed</p>
                                        <p class="text-xs text-gray-500">Yesterday</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-3 flex justify-center">
                            <a href="#" class="text-sm text-navy-600 hover:text-navy-800 font-medium">View all activity</a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-navy-50">
                        <h3 class="font-medium text-navy-800">Upcoming Events</h3>
                    </div>
                    <div class="p-4">
                        <ul class="divide-y divide-gray-200">
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-navy-700 text-white w-10 h-10 rounded-md flex items-center justify-center mr-3">
                                        <span class="font-bold">15</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Group Theory Class</p>
                                        <p class="text-xs text-gray-500">May 15, 2024 · 10:00 AM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-navy-700 text-white w-10 h-10 rounded-md flex items-center justify-center mr-3">
                                        <span class="font-bold">18</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Instructor Meeting</p>
                                        <p class="text-xs text-gray-500">May 18, 2024 · 2:00 PM</p>
                                    </div>
                                </div>
                            </li>
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="bg-navy-700 text-white w-10 h-10 rounded-md flex items-center justify-center mr-3">
                                        <span class="font-bold">22</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-navy-800">Vehicle Maintenance</p>
                                        <p class="text-xs text-gray-500">May 22, 2024 · All Day</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-3 flex justify-center">
                            <a href="#" class="text-sm text-navy-600 hover:text-navy-800 font-medium">View calendar</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Lessons Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-navy-50 flex justify-between items-center">
                    <h3 class="font-medium text-navy-800">Recent Lessons</h3>
                    <a href="#" class="text-sm text-navy-600 hover:text-navy-800 font-medium">View all lessons</a>
                </div>
                
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-navy-700 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-white">Student</th>
                                <th class="px-6 py-3 text-white">Instructor</th>
                                <th class="px-6 py-3 text-white">Date</th>
                                <th class="px-6 py-3 text-white">Time</th>
                                <th class="px-6 py-3 text-white">Status</th>
                                <th class="px-6 py-3 text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-navy-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                            <span class="text-xs font-medium text-gray-700">JD</span>
                                        </div>
                                        <span>John Doe</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Mark Wilson</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">May 10, 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">09:00 - 10:30</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <a href="#" class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-navy-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                            <span class="text-xs font-medium text-gray-700">JS</span>
                                        </div>
                                        <span>Jane Smith</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Sarah Johnson</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">May 11, 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">13:00 - 14:30</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Planned</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <a href="#" class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-navy-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                            <span class="text-xs font-medium text-gray-700">RB</span>
                                        </div>
                                        <span>Robert Brown</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Mark Wilson</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">May 12, 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">15:00 - 16:30</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Canceled</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <a href="#" class="bg-navy-600 hover:bg-navy-700 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                            <i class="fas fa-eye mr-1"></i> View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>