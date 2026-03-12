<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the login attempt.
     */
    public function login(Request $request)
    {
        // 1. Validation: Ensures password and at least one identifier is present
        $request->validate([
            'password'  => 'required|string',
            'email'     => 'required_without:matricule|nullable',
            'matricule' => 'required_without:email|nullable|string',
        ]);

        // 2. Determine if logging in via Matricule or Email
        $loginField = $request->filled('matricule') ? 'matricule' : 'email';
        $loginValue = $request->input($loginField);

        $credentials = [
            $loginField => $loginValue,
            'password'  => $request->password,
        ];

        // 3. Attempt Login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Security: Prevent session fixation
            $request->session()->regenerate();

            // Success: Proceed to logic check
            return $this->authenticated($request, Auth::user());
        }

        // 4. Failure: Return to login with error and keep the ID input
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email', 'matricule');
    }

    /**
     * Post-authentication logic (Verification check & Redirect)
     */
    protected function authenticated(Request $request, $user)
    {
        // SKIP verification check for admin and super_admin
        // This prevents them from being sent back to the home page or verify page
        if ($user->role !== 'admin' && $user->role !== 'super_admin') {
            if (isset($user->is_verified) && !$user->is_verified) {
                return redirect()->route('verify.page'); 
            }
        }

        return $this->redirectByRole($user);
    }

    /**
     * Role-based routing
     */
    private function redirectByRole($user)
    {
        return match ($user->role) {
            'admin', 'super_admin' => redirect()->route('admin.dashboard'),
            'agent'                => redirect()->route('agent.dashboard'),
            'owner'                => redirect()->route('owner.dashboard'),
            'customer'             => redirect()->route('customer.dashboard'),
            default                => redirect('/'),
        };
    }

    /**
     * Logout and clear session
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}