<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;




// --- Public Routes ---
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/contact', function () { return view('contact'); })->name('contact');

Route::get('/restaurants', function () {
    return view('restaurants', ['restaurants' => collect([])]);
})->name('restaurants');

//register routes
Route::post('/register', [RegistrationController::class, 'register']);
Route::post('/verify', [RegistrationController::class, 'verify']);
// 1. This displays the login page
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// 2. This handles the form submission (You already have this)
Route::post('/login', [LoginController::class, 'login']);


