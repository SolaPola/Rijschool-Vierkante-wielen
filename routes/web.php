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

use App\Http\Controllers\instructorcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Carscontroler;
use App\Http\Controllers\Userscontroler;
use App\Http\Controllers\Orderscontroler;
use Livewire\Volt\Volt;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Add 404 error route for demonstration purposes
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// Default dashboard routes to HomeController which will handle role-based redirection
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');


//route to instructors overview


//route to package overview
Route::get('/packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages.index');


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
Route::middleware([InstructorMiddleware::class])->prefix('instructors')->group(function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructors.dashboard');
    Route::get('/students', [InstructorDashboardController::class, 'students'])->name('instructors.students');
    Route::get('/lessons', [LessonsController::class, 'instructorLessons'])->name('instructors.lessons');
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

    // Instructor management routes
    Route::get('/instructors', [InstructorController::class, 'index'])->name('instructors.index');
    Route::get('/instructors/{instructors}/delete', [App\Http\Controllers\InstructorController::class, 'delete'])->name('instructors.delete');

    // Student management routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/delete', [StudentController::class, 'delete'])->name('students.delete');
});

require __DIR__ . '/auth.php';

Route::middleware([InstructorMiddleware::class])->group(function () {
    // Replace the original route with the instructor-specific one
    Route::get('/Cars', 'App\Http\Controllers\Carscontroler@instructorIndex')->name('Cars.index');

    // Keep the other routes the same since instructors should only view cars, not modify them
    Route::get('/Cars/{id}', 'App\Http\Controllers\Carscontroler@show')->name('Cars.show');
});

Route::middleware([AdminMiddleware::class])->group(function () {
    // Admin Car routes - properly named with modern controller syntax
    Route::get('/Admin/Cars', [Carscontroler::class, 'index'])->name('Admin.Cars.index');
    Route::post('/Admin/Cars', [Carscontroler::class, 'store'])->name('Admin.Cars.store');
    Route::get('/Admin/Cars/create', [Carscontroler::class, 'create'])->name('Admin.Cars.create');
    Route::get('/Admin/Cars/{id}', [Carscontroler::class, 'show'])->name('Admin.Cars.show');
    Route::get('/Admin/Cars/{id}/edit', [Carscontroler::class, 'edit'])->name('Admin.Cars.edit');
    Route::put('/Admin/Cars/{id}', [Carscontroler::class, 'update'])->name('Admin.Cars.update');
    Route::delete('/Admin/Cars/{id}', [Carscontroler::class, 'destroy'])->name('Admin.Cars.destroy');

    // Regular Car routes for admin use as well
    Route::get('/Cars', [Carscontroler::class, 'index'])->name('Cars.index');
    Route::post('/Cars', [Carscontroler::class, 'store'])->name('Cars.store');
    Route::get('/Cars/create', [Carscontroler::class, 'create'])->name('Cars.create');
    Route::get('/Cars/{id}', [Carscontroler::class, 'show'])->name('Cars.show');
    Route::get('/Cars/{id}/edit', [Carscontroler::class, 'edit'])->name('Cars.edit');
    Route::put('/Cars/{id}', [Carscontroler::class, 'update'])->name('Cars.update');
    Route::delete('/Cars/{id}', [Carscontroler::class, 'destroy'])->name('Cars.destroy');
});

// Update instructor routes - fix the route naming issue
Route::middleware([InstructorMiddleware::class])->group(function () {
    // Instructors can only view cars, not create/edit/delete them
    Route::get('/instructor/cars', [Carscontroler::class, 'instructorIndex'])->name('Instructor.Cars.index');
    Route::get('/instructor/cars/{id}', [Carscontroler::class, 'show'])->name('Instructor.Cars.show');
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
    // Lessons Routes - Special routes first with correctly named methods
    Route::get('/Lessons/instructors', [LessonsController::class, 'instructorLessons'])->name('Lessons.instructors');
    Route::get('/Lessons/instructor', [LessonsController::class, 'instructorLessons'])->name('Lessons.instructor');

    Route::get('/Lessons/student/{studentId}', [LessonsController::class, 'getStudentLessons'])->name('Lessons.student');
    Route::get('/Lessons/car', [LessonsController::class, 'getCarLessons'])->name('Lessons.car');

    // Standard CRUD routes for lessons
    Route::get('/Lessons', [LessonsController::class, 'index'])->name('Lessons.index');
    Route::post('/Lessons', [LessonsController::class, 'store'])->name('Lessons.store');
    Route::get('/Lessons/create', [LessonsController::class, 'create'])->name('Lessons.create');
    Route::get('/Lessons/{id}', [LessonsController::class, 'show'])->name('Lessons.show');
    Route::get('/Lessons/{id}/edit', [LessonsController::class, 'edit'])->name('Lessons.edit');
    Route::put('/Lessons/{id}', [LessonsController::class, 'update'])->name('Lessons.update');
    Route::delete('/Lessons/{id}', [LessonsController::class, 'destroy'])->name('Lessons.destroy');
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

// Student routes

Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('/student/lessons', [LessonsController::class, 'studentLessons'])->name('student.lessons');
Route::get('/student/lessons/{id}', [LessonsController::class, 'studentShowLesson'])->name('student.lessons.show');
Route::get('/student/lessons/{id}/feedback', [LessonsController::class, 'studentFeedbackForm'])->name('student.lessons.feedback');
Route::post('/student/lessons/{id}/feedback', [LessonsController::class, 'studentStoreFeedback'])->name('student.lessons.saveFeedback');




require __DIR__ . '/auth.php';
