<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // If user is logged in, redirect to the appropriate dashboard
        // if (Auth::check()) {
        //     return $this->redirectBasedOnRole(Auth::user());
        // }

        // Otherwise show the welcome page
        return view('welcome');
    }

    /**
     * Redirect to the appropriate dashboard based on user role.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        return $this->redirectBasedOnRole(Auth::user());
    }
    
    /**
     * Helper method to redirect based on user role
     * 
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isInstructor()) {
            return redirect()->route('instructors.dashboard');
        } elseif ($user->isStudent()) {
            return redirect()->route('student.dashboard');
        }

        // If no specific role dashboard, redirect to home
        return redirect()->route('home');
    }
}
