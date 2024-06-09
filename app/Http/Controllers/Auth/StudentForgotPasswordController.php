<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\SendsPasswordResetEmails; // Make sure to use the trait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class StudentForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function broker()
    {
        return Password::broker('students');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email-student');
    }
}
