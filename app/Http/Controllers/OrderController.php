<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'restaurant_id'    => 'required',
        'food_names'       => 'required|array', 
        'prices'           => 'required|array',
        'delivery_address' => 'required|string|max:255',
        'total_price'      => 'required|numeric',
    ]);

    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please log in to place an order.');
    }

    try {
        Order::create([
            'user_id'          => Auth::id(),
            'restaurant_id'    => $request->restaurant_id,
            // Combine all food names into one string: "Pizza, Burger"
            'food_name'        => implode(', ', $request->food_names), 
            // Use the calculated total_price for the 'price' column
            'price'            => $request->total_price, 
            'quantity'         => count($request->food_names), 
            'delivery_address' => $request->delivery_address,
            'status'           => 'pending',
        ]);

        return redirect()->back()->with('success', 'Order placed successfully!');
        
    } catch (\Exception $e) {
        Log::error('Order Failed: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
    public function acceptOrder(Order $order)
    {
        $order->update(['status' => 'preparing']);
        return back()->with('success', 'Order accepted.');
    }

    public function rejectOrder(Order $order)
    {
        $order->update(['status' => 'rejected']);
        return back()->with('error', 'Order rejected.');
    }

    public function assignAgent(Request $request, Order $order)
    {
        $request->validate(['delivery_agent_id' => 'required']);
        
        $order->update([
            'agent_id' => $request->delivery_agent_id, 
            'status'   => 'delivering' 
        ]);

        return back()->with('success', 'Agent assigned!');
    }
}