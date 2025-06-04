<!-- filepath: c:\Users\solap\Herd\rijschoolvierkantwielen2\resources\views\student\dashboard.blade.php -->
@extends('layouts.main')

@section('title', 'Student Dashboard - Rijschool Vierkante Wielen')

@section('content')
    <!-- Page header -->
    <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-navy-800">Student Dashboard</h2>
        <a href="{{ route('student.lessons') }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-navy-800 uppercase tracking-widest hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all">
            <i class="fas fa-calendar-alt mr-2"></i>View My Lessons
        </a>
    </div>
    
    <!-- Dashboard content goes here -->
    <!-- ...existing code or new dashboard content... -->
@endsection