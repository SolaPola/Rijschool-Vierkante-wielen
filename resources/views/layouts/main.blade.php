<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
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
<body class="font-sans antialiased bg-gray-50">
    <!-- Top Navigation Bar -->
    <div class="bg-navy-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <h1 class="text-xl font-bold">Rijschool Vierkante Wielen</h1>
            @auth
                <div class="flex items-center space-x-4">
                    <span class="text-white">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
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
            @if(auth()->user()->role && auth()->user()->role->name === 'administrator')
                @include('components.admin-sidebar')
            @elseif(auth()->user()->role && auth()->user()->role->name === 'instructor')
                @include('components.instructor-sidebar')
            @elseif(auth()->user()->role && auth()->user()->role->name === 'student')
                @include('components.student-sidebar')
            @endif
        @endauth
        
        <!-- Main Content Area -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <!-- ... footer code ... -->
    
    @yield('scripts')
</body>
</html>
