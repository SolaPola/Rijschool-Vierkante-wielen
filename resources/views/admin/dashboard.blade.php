<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\admin\dashboard.blade.php -->
@extends('layouts.main')

@section('title', 'Admin Dashboard - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Admin Dashboard</h2>
        <div class="flex space-x-2">
            <a href="{{ route('Reports.index') }}" class="inline-flex items-center px-4 py-2 bg-navy-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-navy-700 focus:outline-none focus:ring-2 focus:ring-navy-500 focus:ring-offset-2 transition-all">
                <i class="fas fa-chart-bar mr-2"></i>View Reports
            </a>
        </div>
    </div>
    
    <!-- Dashboard content goes here -->
    <!-- ...existing code or new dashboard content... -->
@endsection