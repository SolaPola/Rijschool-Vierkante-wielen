<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\instructor\dashboard.blade.php -->
<x-layouts.app :title="__('Instructor Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Welcome Banner -->
        <div class="w-full rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-neutral-800">
            <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                {{ __('Welcome to your Instructor Dashboard') }}
            </h1>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                {{ __('Manage your students and schedule lessons from this dashboard.') }}
            </p>
        </div>

 
</x-layouts.app>