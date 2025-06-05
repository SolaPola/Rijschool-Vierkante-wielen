<div class="w-full md:w-64 bg-white rounded-lg shadow-md p-4">
    <nav class="space-y-1">
        <!-- Admin Menu Items -->
        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
        </a>
        <a href="{{ route('accounts.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('accounts.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-users mr-3"></i>Users
        </a>
        <a href="{{ route('Lessons.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Lessons.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-calendar-alt mr-3"></i>Lessons
        </a>
        <a href="{{ route('instructors.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('instructors.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-chalkboard-teacher mr-3"></i>Instructors
        </a>
        <a href="{{ route('students.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('students.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-user-graduate mr-3"></i>Students
        </a>
        <a href="{{ route('Admin.Cars.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Admin.Cars.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-car mr-3"></i>Vehicles
        </a>
        <a href="{{ route('Reports.index') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('Reports.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-chart-bar mr-3"></i>Reports
        </a>
        <a href="{{ route('settings.profile') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-navy-600 text-white font-medium' : 'text-gray-700 hover:bg-navy-50 hover:text-navy-700' }}">
            <i class="fas fa-cog mr-3"></i>Settings
        </a>
    </nav>
</div>
