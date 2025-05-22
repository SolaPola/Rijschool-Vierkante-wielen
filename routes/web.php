<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Carscontroler;
use App\Http\Controllers\Userscontroler;
use App\Http\Controllers\Orderscontroler;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/Users', 'App\Http\Controllers\Userscontroler@index')->name('Users.index');
    Route::post('/Users', 'App\Http\Controllers\Userscontroler@store')->name('Users.store');
    Route::get('/Users/create', 'App\Http\Controllers\Userscontroler@create')->name('Users.create');
    Route::get('/Users/{id}', 'App\Http\Controllers\Userscontroler@show')->name('Users.show');
    Route::get('/Users/{id}/edit', 'App\Http\Controllers\Userscontroler@edit')->name('Users.edit');
    Route::put('/Users/{id}', 'App\Http\Controllers\Userscontroler@update')->name('Users.update');
    Route::delete('/Users/{id}', 'App\Http\Controllers\Userscontroler@destroy')->name('Users.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/Orders', 'App\Http\Controllers\Orderscontroler@index')->name('Orders.index');
    Route::post('/Orders', 'App\Http\Controllers\Orderscontroler@store')->name('Orders.store');
    Route::get('/Orders/create', 'App\Http\Controllers\Orderscontroler@create')->name('Orders.create');
    Route::get('/Orders/{id}', 'App\Http\Controllers\Orderscontroler@show')->name('Orders.show');
    Route::get('/Orders/{id}/edit', 'App\Http\Controllers\Orderscontroler@edit')->name('Orders.edit');
    Route::put('/Orders/{id}', 'App\Http\Controllers\Orderscontroler@update')->name('Orders.update');
    Route::delete('/Orders/{id}', 'App\Http\Controllers\Orderscontroler@destroy')->name('Orders.destroy');
});
Route::middleware(['auth'])->group(function () {

    Route::get('/Products', 'App\Http\Controllers\Productscontroler@index')->name('Products.index');
    Route::post('/Products', 'App\Http\Controllers\Productscontroler@store')->name('Products.store');
    Route::get('/Products/create', 'App\Http\Controllers\Productscontroler@create')->name('Products.create');
    Route::get('/Products/{id}', 'App\Http\Controllers\Productscontroler@show')->name('Products.show');
    Route::get('/Products/{id}/edit', 'App\Http\Controllers\Productscontroler@edit')->name('Products.edit');
    Route::put('/Products/{id}', 'App\Http\Controllers\Productscontroler@update')->name('Products.update');
    Route::delete('/Products/{id}', 'App\Http\Controllers\Productscontroler@destroy')->name('Products.destroy');
});


Route::middleware(['auth'])->group(function () {
    // Students Routes
    Route::get('/Students', 'App\Http\Controllers\StudentsController@index')->name('Students.index');
    Route::post('/Students', 'App\Http\Controllers\StudentsController@store')->name('Students.store');
    Route::get('/Students/create', 'App\Http\Controllers\StudentsController@create')->name('Students.create');
    Route::get('/Students/{id}', 'App\Http\Controllers\StudentsController@show')->name('Students.show');
    Route::get('/Students/{id}/edit', 'App\Http\Controllers\StudentsController@edit')->name('Students.edit');
    Route::put('/Students/{id}', 'App\Http\Controllers\StudentsController@update')->name('Students.update');
    Route::delete('/Students/{id}', 'App\Http\Controllers\StudentsController@destroy')->name('Students.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Lessons Routes
    Route::get('/Lessons', 'App\Http\Controllers\LessonsController@index')->name('Lessons.index');
    Route::post('/Lessons', 'App\Http\Controllers\LessonsController@store')->name('Lessons.store');
    Route::get('/Lessons/create', 'App\Http\Controllers\LessonsController@create')->name('Lessons.create');
    Route::get('/Lessons/{id}', 'App\Http\Controllers\LessonsController@show')->name('Lessons.show');
    Route::get('/Lessons/{id}/edit', 'App\Http\Controllers\LessonsController@edit')->name('Lessons.edit');
    Route::put('/Lessons/{id}', 'App\Http\Controllers\LessonsController@update')->name('Lessons.update');
    Route::delete('/Lessons/{id}', 'App\Http\Controllers\LessonsController@destroy')->name('Lessons.destroy');
    
    // Additional Lessons Routes
    Route::get('/Lessons/student/{studentId}', 'App\Http\Controllers\LessonsController@getStudentLessons')->name('Lessons.student');
    Route::get('/Lessons/instructor', 'App\Http\Controllers\LessonsController@getInstructorLessons')->name('Lessons.instructor');
    Route::get('/Lessons/car', 'App\Http\Controllers\LessonsController@getCarLessons')->name('Lessons.car');
});

Route::middleware(['auth'])->group(function () {
    // Reports Routes
    Route::get('/Reports', 'App\Http\Controllers\ReportsController@index')->name('Reports.index');
    Route::post('/Reports', 'App\Http\Controllers\ReportsController@store')->name('Reports.store');
    Route::get('/Reports/create', 'App\Http\Controllers\ReportsController@create')->name('Reports.create');
    Route::get('/Reports/{id}', 'App\Http\Controllers\ReportsController@show')->name('Reports.show');
    Route::get('/Reports/{id}/edit', 'App\Http\Controllers\ReportsController@edit')->name('Reports.edit');
    Route::put('/Reports/{id}', 'App\Http\Controllers\ReportsController@update')->name('Reports.update');
    Route::delete('/Reports/{id}', 'App\Http\Controllers\ReportsController@destroy')->name('Reports.destroy');
});
require __DIR__.'/auth.php';
