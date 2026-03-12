<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if user is logged in
        // 2. Check if their role column matches the required role (e.g., 'owner')
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Unauthorized action. You do not have the ' . $role . ' role.');
        }

        return $next($request);
    }
}