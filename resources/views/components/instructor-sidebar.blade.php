<div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
    <nav class="space-y-1">
        <!-- Instructor Menu Items -->
        <a href="{{ route('instructors.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('instructors.dashboard') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
        </a>
        <a href="{{ route('instructors.students') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('instructors.students') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-user-graduate mr-3"></i>My Students
        </a>
        <a href="{{ url('/Lessons/instructors') }}" class="block px-4 py-3 rounded-lg {{ request()->is('Lessons/instructors') || request()->is('Lessons/instructor') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-calendar-alt mr-3"></i>My Lessons
        </a>
        <a href="{{ route('Instructor.Cars.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Instructor.Cars.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-car mr-3"></i>Vehicles
        </a>
        <a href="{{ route('settings.profile') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-cog mr-3"></i>Settings
        </a>
    </nav>
</div>
