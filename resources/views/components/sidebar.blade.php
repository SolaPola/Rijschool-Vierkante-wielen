<div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
    <nav class="space-y-1">
        @auth
            @if(auth()->user()->isAdmin())
                <!-- Admin Menu Items -->
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('accounts.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('accounts.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-users-cog mr-3"></i>User Management
                </a>
                <a href="{{ route('instructors.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('instructors.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-chalkboard-teacher mr-3"></i>Instructors
                </a>
                <a href="{{ route('Admin.Cars.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Admin.Cars.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-car mr-3"></i>Cars
                </a>
                <a href="{{ route('packages.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('packages.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-box mr-3"></i>Packages
                </a>
                <a href="{{ route('Reports.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Reports.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-chart-bar mr-3"></i>Reports
                </a>
            @elseif(auth()->user()->isInstructor())
                <!-- Instructor Menu Items -->
                <a href="{{ route('instructors.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('instructors.dashboard') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('instructors.students') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('instructors.students') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-user-graduate mr-3"></i>My Students
                </a>
                <a href="{{ route('Lessons.instructors') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Lessons.instructors') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-calendar-alt mr-3"></i>My Lessons
                </a>
                <a href="{{ route('Cars.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Cars.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-car mr-3"></i>Cars
                </a>
            @elseif(auth()->user()->isStudent())
                <!-- Student Menu Items -->
                <a href="{{ route('student.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('student.lessons') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('student.lessons*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-calendar-alt mr-3"></i>My Lessons
                </a>
                <a href="{{ route('packages.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('packages.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                    <i class="fas fa-box mr-3"></i>Packages
                </a>
            @endif

            <!-- Common Menu Items for All Users -->
            <a href="{{ route('settings.profile') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
                <i class="fas fa-cog mr-3"></i>Settings
            </a>
        @else
            <!-- Guest Menu Items (if any) -->
            <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                <i class="fas fa-sign-in-alt mr-3"></i>Login
            </a>
            <a href="{{ route('register') }}" class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-navy-50 hover:text-navy-700">
                <i class="fas fa-user-plus mr-3"></i>Register
            </a>
        @endauth
    </nav>
</div>
