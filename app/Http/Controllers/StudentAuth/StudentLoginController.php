<?php

namespace App\Http\Controllers\StudentAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class StudentLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student')->except('logout');
    }

    public function showLoginForm()
    {
        return view('student.login');
    }
    
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'ic' => 'required|digits:12',
            'password' => 'required',
        ]);
    
        // Log input values for debugging
        \Log::info('Login Attempt:', $request->only('ic', 'password'));
    
        // Attempt to log in the student
        $credentials = $request->only('ic', 'password');
        $remember = $request->has('remember'); // Check if the "Remember me" checkbox is checked
    
        if (Auth::guard('student')->attempt($credentials, $remember)) {
            // Authentication was successful
            return redirect()->route('student.home');
        }
    
        // Authentication failed
        \Log::error('Login Failed:', ['ic' => $request->input('ic')]);
        return redirect()->route('student.login')->with('error', trans('auth.failed'));
    }    

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('student.login');
    }

}
