<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/Cars', 'App\Http\Controllers\Carscontroler@index')->name('Cars.index');
    Route::post('/Cars', 'App\Http\Controllers\Carscontroler@store')->name('Cars.store');
    Route::get('/Cars/create', 'App\Http\Controllers\Carscontroler@create')->name('Cars.create');
    Route::get('/Cars/{id}', 'App\Http\Controllers\Carscontroler@show')->name('Cars.show');
    Route::get('/Cars/{id}/edit', 'App\Http\Controllers\Carscontroler@edit')->name('Cars.edit');
    Route::put('/Cars/{id}', 'App\Http\Controllers\Carscontroler@update')->name('Cars.update');
    Route::delete('/Cars/{id}', 'App\Http\Controllers\Carscontroler@destroy')->name('Cars.destroy');
});

require __DIR__.'/auth.php';
