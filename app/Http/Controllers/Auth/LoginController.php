<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create() { return view('auth.login'); }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // If not verified, go to verify page
            if (!$user->is_verified) {
                return redirect()->route('verification.page');
            }

            // If verified, go to specific Dashboard
            return match($user->role) {
                'super_admin'      => redirect()->route('admin.dashboard'),
                'restaurant_owner' => redirect()->route('owner.dashboard'),
                'delivery_agent'   => redirect()->route('agent.dashboard'),
                'customer'         => redirect()->route('customer.dashboard'),
                default            => redirect()->route('home'),
            };
        }

        return back()->withErrors(['email' => 'Credentials do not match.'])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}