<div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
    <nav class="space-y-1">
        <a href="{{ route('student.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
        </a>
        <a href="{{ route('student.lessons') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('student.lessons*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-calendar-alt mr-3"></i>My Lessons
        </a>
        <a href="{{ route('packages.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('packages.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-box mr-3"></i>Packages
        </a>
        <a href="{{ route('settings.profile') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-cog mr-3"></i>Settings
        </a>
    </nav>
</div>
