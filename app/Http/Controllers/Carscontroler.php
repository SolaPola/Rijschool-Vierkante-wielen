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

    public function store(Request $request)
    {   
        
        $data = $request->validate([
            'brand' => 'required|VARCHAR|max:100',
            'Type' => 'required|VARCHAR|max:100',
            'license_plate' => 'required|VARCHAR|max:100',
            'fuel' => 'required|enum:electric, petrol|max:100',
        ]);
        

        // Process the data (e.g., save to database, etc.)

        return redirect()->back()->with('success', 'Data submitted successfully!', $data);
    }

    /**
     * Show the form for creating a new car.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role->name !== 'administrator') {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to create cars');
        }
        
        return view('cars.create');
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
        
        // Get cars with pagination
        $cars = $query->paginate(10);
        
        // Get data for filters
        $brands = Car::where('isactive', true)->select('brand')->distinct()->pluck('brand');
        $fuelTypes = Car::where('isactive', true)->select('fuel')->distinct()->pluck('fuel');
        
        return view('cars.instructor-index', compact('cars', 'brands', 'fuelTypes'));
    }
    // public function show($id)
    // {
    //     // Logic to retrieve and display a specific record
    //     return view('show', compact('id'));
    // }
    // public function edit($id)
    // {
    //     // Logic to retrieve and display a specific record for editing
    //     return view('edit', compact('id'));
    // }
    // public function update(Request $request, $id)
    // {
    //     $data = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'message' => 'required|string|max:1000',
    //     ]);

    //     // Logic to update the record in the database

    //     return redirect()->route('autocontroler.show', ['id' => $id])->with('success', 'Data updated successfully!');
    // }
    // public function destroy($id)
    // {
    //     // Logic to delete the record from the database

    //     return redirect()->route('autocontroler.index')->with('success', 'Data deleted successfully!');
    // }
}
