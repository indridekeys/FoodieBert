<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::get('/debug-me', function() {
    $user = Auth::user();
    if (!$user) return "Not logged in.";
    return [
        'name' => $user->name,
        'role' => $user->role,
        'matricule' => $user->matricule,
        'verified' => $user->is_verified
    ];
})->middleware('auth');

// --- Public Routes ---
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');

Route::get('/restaurants', function () {
    return view('restaurants', ['restaurants' => collect([])]);
})->name('restaurants');

// --- Authentication Routes ---
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

// --- Verification Gate ---
// This page is the "Security Checkpoint"
Route::get('/verify-identity', function () {
    $user = Auth::user();
    
    // If the user already finished verification, don't let them stay here.
    // Send them to their specific HQ immediately.
    if ($user->is_verified) {
        return match($user->role) {
            'restaurant_owner' => redirect()->route('owner.dashboard'),
            'delivery_agent'   => redirect()->route('agent.dashboard'),
            'customer'         => redirect()->route('customer.dashboard'),
            'super_admin'      => redirect()->route('admin.dashboard'),
            default            => redirect()->route('home'),
        };
    }
    return view('auth.verify');
})->name('verification.page')->middleware('auth');

// This handles the "Handshake" after the user enters the code
Route::post('/verify-identity', function (Request $request) {
    if ($request->filled('code')) {
        $user = Auth::user();
        $user->update(['is_verified' => true]);

        // SUCCESS: Send to specific dashboard based on role
        return match($user->role) {
            'restaurant_owner' => redirect()->route('owner.dashboard'),
            'delivery_agent'   => redirect()->route('agent.dashboard'),
            'customer'         => redirect()->route('customer.dashboard'),
            default            => redirect()->route('home'),
        };
    }
    return back()->with('error', 'Please enter a valid verification code.');
})->name('verification.verify')->middleware('auth');

// --- Protected Role Dashboards ---
// We use 'verified_citizen' to ensure they can't access these until they verify
Route::middleware(['auth', 'verified_citizen'])->group(function () {
    
    // Customer Dashboard
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    // Owner Dashboard (Proprietor HQ)
    Route::get('/owner/hq', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');

    // Delivery Agent Dashboard
    Route::get('/agent/portal', function () {
        return view('agent.dashboard');
    })->name('agent.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

// --- Super Admin "Empire" Protected Routes ---
Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/empire-hq', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/admin/password', [AdminController::class, 'updatePassword'])->name('admin.password.update');
    Route::post('/admin/restaurants', [RestaurantController::class, 'store'])->name('admin.restaurants.store');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

// Remove any old admin.profile.update routes and use this:
Route::middleware('auth')->group(function () {
    Route::patch('/profile/identity-update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/verify-account', function () {
    return view('auth.verify-otp');
})->name('verify.page');

Route::post('/verify-otp', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verify.otp');

