<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\admin\dashboard.blade.php -->
<x-layouts.app :title="__('Administrator Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome Banner -->
        <div class="w-full rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                {{ __('Welcome to the Administrator Dashboard') }}
            </h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                {{ __('Manage the entire driving school system from this central dashboard.') }}
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex flex-col rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="text-sm font-medium uppercase text-gray-500 dark:text-gray-400">{{ __('Total Students') }}</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">127</p>
                <div class="mt-2">
                    <span class="text-sm text-green-600 dark:text-green-400">+12% <span class="text-gray-500 dark:text-gray-400">from last month</span></span>
                </div>
            </div>
            <div class="flex flex-col rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="text-sm font-medium uppercase text-gray-500 dark:text-gray-400">{{ __('Total Instructors') }}</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">12</p>
                <div class="mt-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">No change from last month</span>
                </div>
            </div>
            <div class="flex flex-col rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="text-sm font-medium uppercase text-gray-500 dark:text-gray-400">{{ __('Lessons This Week') }}</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">48</p>
                <div class="mt-2">
                    <span class="text-sm text-green-600 dark:text-green-400">+8% <span class="text-gray-500 dark:text-gray-400">from last week</span></span>
                </div>
            </div>
            <div class="flex flex-col rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h3 class="text-sm font-medium uppercase text-gray-500 dark:text-gray-400">{{ __('Revenue This Month') }}</h3>
                <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">€15,750</p>
                <div class="mt-2">
                    <span class="text-sm text-green-600 dark:text-green-400">+15% <span class="text-gray-500 dark:text-gray-400">from last month</span></span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- User Management Card -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-100 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ __('User Management') }}
                    </h2>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Manage students, instructors, and administrators. Create, edit, and deactivate accounts.') }}
                </p>
                <div class="mt-6">
                    <a href="{{ route('accounts.index') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                        {{ __('Manage Users') }}
                    </a>
                </div>
            </div>

            <!-- Lesson Scheduling Card -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-100 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ __('Lesson Scheduling') }}
                    </h2>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('View and manage all scheduled lessons. Assign instructors to students.') }}
                </p>
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                        {{ __('Manage Schedule') }}
                    </a>
                </div>
            </div>

            <!-- System Settings Card -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-100 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ __('System Settings') }}
                    </h2>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Configure global settings for the driving school system.') }}
                </p>
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                        {{ __('Manage Settings') }}
                    </a>
                </div>
            </div>

            <!-- Reports & Analytics Card -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-100 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ __('Reports & Analytics') }}
                    </h2>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('View reports on student progress, instructor performance, and overall school metrics.') }}
                </p>
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                        {{ __('View Reports') }}
                    </a>
                </div>
            </div>

            <!-- Financial Management Card -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-100 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ __('Financial Management') }}
                    </h2>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Manage payments, invoices, and financial reports for the driving school.') }}
                </p>
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                        {{ __('Manage Finances') }}
                    </a>
                </div>
            </div>

            <!-- Vehicle Management Card -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center">
                    <div class="flex-shrink-0 p-3 rounded-md bg-indigo-100 dark:bg-indigo-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h2 class="ml-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ __('Vehicle Management') }}
                    </h2>
                </div>
                <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Manage the fleet of training vehicles. Track maintenance and availability.') }}
                </p>
                <div class="mt-6">
                    <a href="#" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800">
                        {{ __('Manage Vehicles') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Performance -->
        <div class="grid gap-4 md:grid-cols-3">
            <!-- Recent Activity -->
            <div class="md:col-span-2 rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-medium text-gray-900 dark:text-white">{{ __('Recent Activity') }}</h2>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        {{ __('View all') }}
                    </a>
                </div>
                <div class="space-y-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 dark:bg-indigo-900">
                                <span class="text-xs font-medium text-indigo-600 dark:text-indigo-300">JS</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('New student registered') }}: John Smith
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('30 minutes ago') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 dark:bg-indigo-900">
                                <span class="text-xs font-medium text-indigo-600 dark:text-indigo-300">MB</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Instructor updated schedule') }}: Maria Brown
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('2 hours ago') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 dark:bg-indigo-900">
                                <span class="text-xs font-medium text-indigo-600 dark:text-indigo-300">AD</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Payment received') }}: Anna Davis - €150
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('5 hours ago') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3 dark:bg-indigo-900">
                                <span class="text-xs font-medium text-indigo-600 dark:text-indigo-300">RW</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('Vehicle maintenance completed') }}: Car #04
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Yesterday at 2:30 PM') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pass Rate Analytics -->
            <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
                <h2 class="text-xl font-medium text-gray-900 dark:text-white mb-4">{{ __('Exam Pass Rate') }}</h2>
                <div class="flex flex-col items-center">
                    <div class="relative h-36 w-36">
                        <svg class="h-36 w-36" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <!-- Background circle -->
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#e5e7eb" stroke-width="2" class="dark:stroke-gray-700"></circle>
                            
                            <!-- Foreground circle (85% complete) -->
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#4f46e5" stroke-width="2" stroke-dasharray="100.53 100.53" stroke-dashoffset="15.08" class="dark:stroke-indigo-500"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-3xl font-bold text-gray-900 dark:text-white">85%</span>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                        {{ __('Current pass rate for driving exams') }}
                    </p>
                </div>
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Theory Exams') }}</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">92%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: 92%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center mb-1 mt-3">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Practical Exams') }}</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">78%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-indigo-600 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-medium text-gray-900 dark:text-white">{{ __('Today\'s Schedule Overview') }}</h2>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                    {{ __('View full schedule') }}
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('Time') }}
                            </th>
                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('Student') }}
                            </th>
                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('Instructor') }}
                            </th>
                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('Topic') }}
                            </th>
                            <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                {{ __('Status') }}
                            </th>
                            <th scope="col" class="relative px-4 py-3.5">
                                <span class="sr-only">{{ __('Actions') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-neutral-800">
                        <tr>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">09:00 - 10:30</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Jane Doe</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Mark Wilson</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 dark:text-gray-400">Highway Driving</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm">
                                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ __('Confirmed') }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('Details') }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">11:00 - 12:30</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">John Brown</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Sarah Johnson</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 dark:text-gray-400">Parallel Parking</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm">
                                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ __('Confirmed') }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('Details') }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">13:00 - 14:30</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Michael Lee</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Mark Wilson</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 dark:text-gray-400">City Driving</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm">
                                <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                    {{ __('Pending') }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('Details') }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">15:00 - 16:30</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Alice Thompson</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-900 dark:text-white">Sarah Johnson</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-500 dark:text-gray-400">Exam Preparation</td>
                            <td class="whitespace-nowrap px-4 py-4 text-sm">
                                <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    {{ __('Confirmed') }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-medium">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('Details') }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>