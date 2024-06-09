<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Correct import for Auth facade
use Illuminate\Support\Facades\Password;

class StudentResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected function broker()
    {
        return Password::broker('students');
    }

    protected function guard()
    {
        return Auth::guard('student');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset-student')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request) // Make sure this method is public
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // We will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }
}
