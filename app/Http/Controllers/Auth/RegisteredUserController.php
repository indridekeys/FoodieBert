<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed'], // This looks for 'password_confirmation'
        'role' => ['required', 'string'],
        'picture' => ['nullable', 'image', 'max:2048'], // Handle the optional picture
    ]);

    // Handle picture upload if exists
    $path = null;
    if ($request->hasFile('picture')) {
        $path = $request->file('picture')->store('profiles', 'public');
    }

    $prefix = match($request->role) {
        'restaurant_owner' => 'OWN_ID_',
        'delivery_agent'   => 'AGT_ID_',
        'customer'         => 'CUS_ID_',
        default            => 'USR_',
    };

    $matricule = $prefix . strtoupper(bin2hex(random_bytes(3)));

    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role' => $request->role,
        'matricule' => $matricule,
        'picture' => $path, // Save the path
        'is_verified' => false,
    ]);

    \Illuminate\Support\Facades\Auth::login($user);

    return redirect()->route('verification.page');
}
}