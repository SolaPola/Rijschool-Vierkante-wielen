<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    /**
     * Display the instructor dashboard.
     */
    public function index()
    {

        return view('instructor.dashboard');
    }

    /**
     * Display the instructor's students page.
     */
}
