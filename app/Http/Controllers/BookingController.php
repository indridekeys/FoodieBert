<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
 public function store(Request $request)
{
    $validated = $request->validate([
        'restaurant_id' => 'required|exists:restaurants,id',
        'name'          => 'required|string|max:255',
        'date'          => 'required|date',
        'time'          => 'required',
        'guests'        => 'required|integer|min:1',
    ]);

    // Manually add the logged-in user's ID to the data array
    $validated['user_id'] = auth()->id();

    // Now it will save without the NULL error
    \App\Models\Booking::create($validated);

    return back()->with('success', 'Table booked successfully!');
}

    // Save with the restaurant relationship
    \App\Models\Booking::create($validated);

    return back()->with('success', 'Table booked at ' . \App\Models\Restaurant::find($validated['restaurant_id'])->name);
}
}
