<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\accounts\index.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Rijschool Vierkante Wielen</title>
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
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('accounts.index') }}"
                    class="block px-4 py-3 rounded-lg bg-navy-600 text-white font-medium">
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
                <a href="{{ route('settings.profile') }}"
                    class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                    <i class="fas fa-cog mr-3"></i>Settings
                </a>
            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1">
            <!-- Page header -->
            <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-navy-800">User / Account Management</h2>
                <a href="{{ route('accounts.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
                    <i class="fas fa-plus mr-2"></i>Create New User
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md"
                    role="alert">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif


                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-navy-700 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-white">Name</th>
                                <th class="px-6 py-3 text-white">Username</th>
                                <th class="px-6 py-3 text-white">Email</th>
                                <th class="px-6 py-3 text-white">Role</th>
                                <th class="px-6 py-3 text-white">Status</th>
                                <th class="px-6 py-3 text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-navy-50">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-navy-900">
                                        <div class="flex items-center">
                                            <div
                                                class="h-8 w-8 rounded-full bg-navy-100 flex items-center justify-center mr-3">
                                                <span class="text-xs font-medium text-navy-700">
                                                    {{ strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span>{{ $user->firstname }} {{ $user->infix }}
                                                    {{ $user->lastname }}</span>
                                                <p class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($user->birthdate)->format('d-m-Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-navy-100 text-navy-800 rounded-full text-xs">
                                            {{ ucfirst($user->role->name) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->is_active)
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('accounts.edit', $user) }}"
                                                class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('accounts.destroy', $user) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this user?')"
                                                    class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-sm inline-flex items-center">
                                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No users found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
