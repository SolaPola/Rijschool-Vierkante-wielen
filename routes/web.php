<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\InstructorMiddleware;
use App\Http\Middleware\StudentMiddleware;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Add 404 error route for demonstration purposes
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// Default dashboard routes to HomeController which will handle role-based redirection
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

// User settings routes (accessible by all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Student specific routes
Route::middleware([StudentMiddleware::class])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

// Instructor specific routes
Route::middleware([InstructorMiddleware::class])->prefix('instructor')->group(function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
    Route::get('/students', [InstructorDashboardController::class, 'students'])->name('instructor.students');
});

// Admin specific routes
Route::middleware([Adminmiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User management routes
    Route::get('/accounts', [UserController::class, 'index'])->name('accounts.index');
    Route::get('/accounts/create', [UserController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [UserController::class, 'store'])->name('accounts.store');
    Route::get('/accounts/{user}', [UserController::class, 'show'])->name('accounts.show');
    Route::get('/accounts/{user}/edit', [UserController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts/{user}', [UserController::class, 'update'])->name('accounts.update');
    Route::delete('/accounts/{user}', [UserController::class, 'destroy'])->name('accounts.destroy');
});

require __DIR__ . '/auth.php';
