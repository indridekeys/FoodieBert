<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Mail\BookingStatusUpdated;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display bookings for the owner's dashboard
     */
    public function index()
    {
        // Get only the bookings for restaurants owned by the authenticated user
        $bookings = Booking::whereHas('restaurant', function ($query) {
            $query->where('owner_id', auth()->id());
        })
        ->with('restaurant') // Eager load to show restaurant name in table
        ->latest()
        ->get();

        return view('owner.dashboard', compact('bookings'));
    }

    /**
     * Store a new booking (Client side)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email', 
            'date'          => 'required|date',
            'time'          => 'required',
            'guests'        => 'required|integer|min:1|max:15',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending'; // Ensure default status is set

        Booking::create($validated);

        $restaurant = Restaurant::find($validated['restaurant_id']);

        return back()->with('success', "Table booked successfully at {$restaurant->name}!");
    }

    /**
     * Update booking status (Owner side)
     */
 public function updateStatus(Request $request, $id)
{
    $booking = Booking::findOrFail($id);
    $booking->update(['status' => $request->status]);

    // Send the email to the guest
    Mail::to($booking->email)->send(new BookingStatusUpdated($booking));

    return back()->with('success', "Status updated and email sent to {$booking->name}.");
}

public function cancel($id)
{
    $booking = \App\Models\Booking::where('id', $id)
        ->where('user_id', auth()->id()) // Security: ensure it's their booking
        ->where('status', 'pending')     // Only allow canceling if still pending
        ->firstOrFail();

    $booking->update(['status' => 'cancelled']);

    return back()->with('success', "Your reservation at {$booking->restaurant->name} has been cancelled.");
}
}