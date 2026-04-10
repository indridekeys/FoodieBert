<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access the admin area.');
        }

        $user = Auth::user();

        // 2. If Super Admin, allow access (bypassing extra verification checks for now)
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // 3. Fallback for everyone else
        return redirect('/')->with('error', 'Unauthorized Access.');
    }
}