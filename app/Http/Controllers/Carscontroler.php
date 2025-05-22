<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class Carscontroler extends Controller
{
    public function index()
    {
        $cars = Car::all(); // Fetch all cars from database
        return view('Cars.index', compact('cars'));
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
