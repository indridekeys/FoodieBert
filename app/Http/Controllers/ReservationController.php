<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Make sure you have a Reservation model

class ReservationController extends Controller
{
    /**
     * Show the reservation form.
     */
    public function index()
    {
        return view('reservations.index'); 
    }

    /**
     * Store a new reservation.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'reservation_date' => 'required|date|after:today',
            'guests' => 'required|integer|min:1|max:20',
        ]);

        // 2. Save to the database
        // Assuming you have a Reservation model and table
        Reservation::create($validated);

        // 3. Redirect with a success message
        return redirect()->back()->with('success', 'Your table has been booked!');
    }
}