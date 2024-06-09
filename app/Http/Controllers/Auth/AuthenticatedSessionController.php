<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $selectedRole = $request->input('role');

        if ($user->role !== $selectedRole) {
            Auth::logout();
            return back()->withErrors([
                'role' => 'The selected role does not match your account role.',
            ]);
        }

        // Redirect to the appropriate dashboard based on the role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'counsellor':
                return redirect()->route('counsellor.assessment');
            default:
                return abort(403, 'Unauthorized');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $guard = null;
        $redirectRoute = '/';
    
        if (Auth::guard('web')->check()) {
            $guard = 'web';
            $redirectRoute = '/';
        } elseif (Auth::guard('student')->check()) {
            $guard = 'student';
            $redirectRoute = route('student.login');
        }
    
        if ($guard) {
            Auth::guard($guard)->logout();
    
            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
        }
    
        return redirect($redirectRoute);
    }    
    
}
