<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index()
    {


        return view('student.dashboard');
    }
}
