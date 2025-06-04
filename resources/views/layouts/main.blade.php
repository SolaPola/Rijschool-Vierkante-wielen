<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rijschool Vierkante Wielen')</title>
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
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="bg-navy-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold">Rijschool Vierkante Wielen</h1>
            @auth
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-white">Welcome, {{ Auth::user()->firstname }}</span>
                    <a href="{{ route('settings.profile') }}" class="bg-yellow-500 hover:bg-yellow-400 text-navy-800 px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-user mr-2"></i>Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-yellow-300">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-white hover:text-yellow-300">Login</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-yellow-300">Register</a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row gap-6">
        <!-- Role-specific Sidebar -->
        @auth
            @if(auth()->user()->isAdmin())
                @include('components.admin-sidebar')
            @elseif(auth()->user()->isInstructor())
                @include('components.instructor-sidebar')
            @elseif(auth()->user()->isStudent())
                @include('components.student-sidebar')
            @endif
        @endauth
        
        <!-- Main Content Area -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>

    @yield('scripts')
</body>
</html>
