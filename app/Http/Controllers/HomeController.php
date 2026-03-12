<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
    $stats = [
        'total_spots'  => \App\Models\Restaurant::count(),
        'total_users'  => \App\Models\User::count(),
        'total_orders' => 1240, // Static for now, dynamic later!
    ];
    $restaurants = \App\Models\Restaurant::all();
    
    return view('welcome', compact('stats', 'restaurants'));
}
}
