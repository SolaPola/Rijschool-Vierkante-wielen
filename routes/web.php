<?php

use App\Http\Controllers\instructorcontroller;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

   //route to instructor overview
Route::resource('instructors', InstructorController::class);
Route::get('/instructors/{instructor}/delete', [App\Http\Controllers\InstructorController::class, 'delete'])->name('instructors.delete');

//route to package overview
Route::get('/packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages.index');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});



require __DIR__.'/auth.php';
