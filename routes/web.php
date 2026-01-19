<?php

use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Restaurants Page (The one causing the error)
Route::get('/restaurants', function () {
    // We pass an empty collection so the @forelse loop doesn't crash
    return view('restaurants', [
        'restaurants' => collect([]) 
    ]);
})->name('restaurants');