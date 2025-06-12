<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class Carscontroler extends Controller
{
    /**
     * Display a listing of the cars.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Car::query();
        
        // Apply filters if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhere('fuel', 'like', "%{$search}%");
            });
        }
        
        // Apply specific filters if provided
        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand', 'like', "%{$request->brand}%");
        }
        
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', 'like', "%{$request->type}%");
        }
        
        if ($request->has('license_plate') && !empty($request->license_plate)) {
            $query->where('license_plate', 'like', "%{$request->license_plate}%");
        }
        
        if ($request->has('fuel') && !empty($request->fuel)) {
            $query->where('fuel', $request->fuel);
        }
        
        if ($request->has('status') && $request->status != 'all') {
            $isActive = $request->status === 'active';
            $query->where('isactive', $isActive);
        }
        
        // Get cars with pagination
        $cars = $query->paginate(10);
        
        // Get data for filters
        $brands = Car::select('brand')->distinct()->pluck('brand');
        $fuelTypes = Car::select('fuel')->distinct()->pluck('fuel');
        
        return view('admin.cars.index', compact('cars', 'brands', 'fuelTypes'));
    }

    /**
     * Show the form for creating a new car.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // No need to check if the user is admin here as the middleware handles that
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
            // Check if a car with this license plate already exists
            $existingCar = Car::where('license_plate', $request->license_plate)->first();
            if ($existingCar) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['license_plate' => 'A car with this license plate already exists in the system.']);
            }

            // Validate the incoming request with proper Laravel validation rules
            $validated = $request->validate([
                'brand' => 'required|string|max:100',
                'type' => 'required|string|max:100',
                'license_plate' => 'required|string|max:20|unique:cars',
                'fuel' => 'required|in:petrol,diesel,electric,hybrid',
                'remark' => 'nullable|string|max:500',
            ]);

            // Create the car using direct SQL to avoid any potential ORM issues
            $car = new Car();
            $car->brand = $validated['brand'];
            $car->type = $validated['type'];
            $car->license_plate = $validated['license_plate'];
            $car->fuel = $validated['fuel'];
            $car->remark = $validated['remark'];
            $car->isactive = (bool)$request->has('isactive');
            $car->save();

            // Debug output to see what's happening
            \Illuminate\Support\Facades\Log::info('Car created successfully', [
                'car_id' => $car->id,
                'brand' => $car->brand,
                'license_plate' => $car->license_plate,
            ]);

            // Redirect with success message
            return redirect()->route('Admin.Cars.index')
                ->with('success', 'Car created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors - check specifically for license plate uniqueness
            $errors = $e->validator->errors();
            
            if ($errors->has('license_plate') && 
                str_contains($errors->first('license_plate'), 'taken')) {
                // Override with a more user-friendly message
                $errors->add('license_plate', 'A car with this license plate already exists in the system.');
            }
            
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        } catch (\Exception $e) {
            // Log the error details including the SQL error
            \Illuminate\Support\Facades\Log::error('Error creating car: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            
            // Redirect back with error and preserve input
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while adding the car. Please try again later.');
        }
    }

    /**
     * Display a listing of the cars for instructors.
     *
     * @return \Illuminate\Http\Response
     */
    public function instructorIndex(Request $request)
    {
        $query = Car::where('isactive', true);
        
        // Apply filters if provided
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%")
                  ->orWhere('fuel', 'like', "%{$search}%");
            });
        }
        
        // Apply specific filters
        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand', 'like', "%{$request->brand}%");
        }
        
        if ($request->has('fuel') && !empty($request->fuel)) {
            $query->where('fuel', $request->fuel);
        }
        
        // Check if there are any active cars before pagination
        $activeCarsExist = $query->count() > 0;
        
        // Get cars with pagination
        $cars = $query->paginate(10);
        
        // Get data for filters - even when no cars, we need these for the filter dropdowns
        $brands = Car::where('isactive', true)->select('brand')->distinct()->pluck('brand');
        $fuelTypes = Car::where('isactive', true)->select('fuel')->distinct()->pluck('fuel');
        
        // Add a flag to indicate if there are no active cars
        $noActiveCars = !$activeCarsExist;
        
        return view('cars.instructor-index', compact('cars', 'brands', 'fuelTypes', 'noActiveCars'));
    }
    /**
     * Display the specified car.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $car = Car::findOrFail($id);
            
            // Get usage statistics
            $upcomingLessonsCount = 0;
            $pastLessonsCount = 0;
            
            // Try to get lesson counts if possible
            if (class_exists('App\Models\Lesson')) {
                $upcomingLessonsCount = \App\Models\Lesson::where('vehicle_id', $id)
                    ->where('start_time', '>', now())
                    ->count();
                    
                $pastLessonsCount = \App\Models\Lesson::where('vehicle_id', $id)
                    ->where('start_time', '<', now())
                    ->count();
            }

            // Determine the view based on the user's role
            if (Auth::check() && Auth::user()->isAdmin()) {
                return view('admin.cars.show', compact('car', 'upcomingLessonsCount', 'pastLessonsCount'));
            } else {
                return view('cars.show', compact('car', 'upcomingLessonsCount', 'pastLessonsCount'));
            }
            
        } catch (\Exception $e) {
            $redirectRoute = Auth::check() && Auth::user()->isAdmin() ? 'Admin.Cars.index' : 'Instructor.Cars.index';
            return redirect()->route($redirectRoute)
                ->with('error', 'Error retrieving car details: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified car.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $car = Car::findOrFail($id);
            return view('admin.cars.edit', compact('car'));
        } catch (\Exception $e) {
            return redirect()->route('Admin.Cars.index')
                ->with('error', 'Error retrieving car: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $car = Car::findOrFail($id);
            
            // Check if license plate already exists for another car
            $existingCar = Car::where('license_plate', $request->license_plate)
                ->where('id', '!=', $id)
                ->first();
                
            if ($existingCar) {
                return redirect()->back()
                    ->withInput() // Keep all form input
                    ->with('error', 'Een lesauto met dit kenteken bestaat al in het systeem');
            }
            
            // Validate the incoming request
            $validated = $request->validate([
                'brand' => 'required|string|max:100',
                'type' => 'required|string|max:100',
                'license_plate' => 'required|string|max:20|unique:cars,license_plate,' . $id,
                'fuel' => 'required|in:electric,petrol,diesel,hybrid',
                'remark' => 'nullable|string|max:500',
            ]);

            // Explicitly set isactive as a boolean value
            $car->brand = $validated['brand'];
            $car->type = $validated['type'];
            $car->license_plate = $validated['license_plate'];
            $car->fuel = $validated['fuel'];
            $car->remark = $validated['remark'];
            $car->isactive = (bool)$request->has('isactive');
            $car->save();

            // Debug logging
            \Illuminate\Support\Facades\Log::info('Car updated successfully', [
                'car_id' => $car->id,
                'brand' => $car->brand,
                'type' => $car->type,
                'license_plate' => $car->license_plate,
                'fuel' => $car->fuel,
                'isactive' => $car->isactive
            ]);

            return redirect()->route('Admin.Cars.index')
                ->with('success', 'Car updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors specifically for license plate uniqueness
            $errors = $e->validator->errors();
            
            if ($errors->has('license_plate') && 
                str_contains($errors->first('license_plate'), 'taken')) {
                return redirect()->back()
                    ->withInput() // Keep all form input
                    ->with('error', 'Een lesauto met dit kenteken bestaat al in het systeem');
            }
            
            // For other validation errors, return with the validation errors
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating car: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->withInput() // Keep all form input
                ->with('error', 'Error updating car: ' . $e->getMessage());
        }
    }
    /**
     * Set a car to maintenance mode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setMaintenance(Request $request, $id)
    {
        try {
            $car = Car::findOrFail($id);
            
            $validated = $request->validate([
                'maintenance_reason' => 'required|string|max:255',
                'maintenance_until' => 'required|date',
            ]);
            
            $car->isactive = false;
            $car->maintenance_reason = $validated['maintenance_reason'];
            $car->maintenance_until = $validated['maintenance_until'];
            $car->save();
            
            return redirect()->route('Admin.Cars.show', $id)
                ->with('success', 'Car set to maintenance mode successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error setting car to maintenance: ' . $e->getMessage());
        }
    }
}
