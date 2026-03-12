<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * This method acts as the "Traffic Controller"
     * It sends users to the right dashboard based on their role.
     */
    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'agent'    => redirect()->route('agent.dashboard'),
            'owner'    => redirect()->route('owner.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default    => redirect('/'),
        };
    }
}