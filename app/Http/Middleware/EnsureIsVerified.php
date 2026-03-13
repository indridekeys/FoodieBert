<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 1. If not verified, force them to the verification page
            if (!$user->is_verified && !$request->is('verify-identity*')) {
                return redirect()->route('verification.page');
            }

            // 2. If already verified and trying to access login/register/verify
            if ($user->is_verified && ($request->is('login') || $request->is('register') || $request->is('verify-identity*'))) {
                return $this->redirectBasedOnRole($user);
            }
        }

        return $next($request);
    }

    protected function redirectBasedOnRole($user)
    {
        return match($user->role) {
            'super_admin'      => redirect()->route('admin.dashboard'),
            'restaurant_owner' => redirect()->route('owner.dashboard'),
            'delivery_agent'   => redirect()->route('agent.dashboard'),
            'customer'         => redirect()->route('customer.dashboard'),
            default            => redirect()->route('home'),
        };
    }
}