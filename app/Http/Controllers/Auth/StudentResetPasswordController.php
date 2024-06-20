<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password as FacadePassword;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;
use App\Traits\ResetsPasswords;

class StudentResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected function broker()
    {
        return FacadePassword::broker('students');
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

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                RulesPassword::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        return $response == FacadePassword::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));

        // Increment pass_status by 1
        $user->pass_status += 1;

        $user->save();

        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect()->route('student.login')->with('status', __($response));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => __($response)]);
    }
}
