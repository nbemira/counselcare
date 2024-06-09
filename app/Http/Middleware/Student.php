<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Student
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated as a student
        if (Auth::guard('student')->check()) {
            // If authenticated as a student, redirect to student home
            return redirect()->route('student.home');
        }

        // If not authenticated as a student, redirect to student login with an error message
        return redirect()->route('student.login')->with('error', 'Please Login First');
    }
}