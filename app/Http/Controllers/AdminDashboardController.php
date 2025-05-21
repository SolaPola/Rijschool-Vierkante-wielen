<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get total students count


        return view('admin.dashboard');
    }
}
