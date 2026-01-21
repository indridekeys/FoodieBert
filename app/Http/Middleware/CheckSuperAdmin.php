<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Only allow if logged in AND role is super_admin
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Unauthorized Access.');
    }
}