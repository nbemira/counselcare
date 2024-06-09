<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Display the password update form.
     */
    public function showUpdatePasswordForm(Request $request)
    {
        return view('profile.partials.update-password-form', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->pass_status = $user->pass_status + 1;
        $user->save();

        return Redirect::route('profile.update-password-form')->with('status', 'Your password has been updated successfully');
    }
}
