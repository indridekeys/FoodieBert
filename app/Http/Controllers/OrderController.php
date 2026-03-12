<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Agent claims a pending mission from the queue
     */
    public function accept($id)
    {
        $order = Order::findOrFail($id);

        // Prevent double-claiming
        if ($order->agent_id !== null) {
            return back()->with('error', 'This mission has already been claimed by another agent.');
        }

        $order->update([
            'agent_id' => Auth::id(),
            'status'   => 'picked_up', // Moves it to the "Current Mission" section in Blade
        ]);

        return back()->with('success', 'Mission accepted! Check your Current Mission for details.');
    }

    /**
     * Agent completes the mission and triggers payout
     */
    public function complete($id)
    {
        // Security: Ensure the order belongs to the authenticated agent and is in 'picked_up' status
        $order = Order::where('id', $id)
                      ->where('agent_id', Auth::id())
                      ->where('status', 'picked_up')
                      ->firstOrFail();

        try {
            // Use a transaction to ensure both DB updates happen or none at all
            DB::transaction(function () use ($order) {
                // 1. Update order status to delivered
                $order->update(['status' => 'delivered']);

                // 2. Create the payout record in the transactions table
                Transaction::create([
                    'user_id'     => Auth::id(),
                    'amount'      => $order->delivery_fee,
                    'type'        => 'delivery_fee',
                    'description' => "Payout for Order #{$order->id} delivery"
                ]);
            });

            return back()->with('success', 'Mission accomplished! Delivery fee added to your vault.');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong while completing the mission.');
        }
    }

    /**
     * Toggle Agent Online/Offline Status (via AJAX)
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'is_available' => 'required|boolean'
        ]);

        $user = Auth::user();
        
        $user->update([
            'is_available' => $request->is_available
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => $user->is_available ? 'You are now online' : 'You are now offline',
            'is_online' => $user->is_available
        ]);
    }

    public function earnings()
{
    $user = Auth::user();
    
    // Calculate stats
    $totalEarned = \App\Models\Transaction::where('user_id', $user->id)->sum('amount');
    $thisMonthEarned = \App\Models\Transaction::where('user_id', $user->id)
        ->whereMonth('created_at', now()->month)
        ->sum('amount');

    // Group earnings by date for the table
    $dailyEarnings = \App\Models\Transaction::where('user_id', $user->id)
        ->select(\DB::raw('DATE(created_at) as date'), \DB::raw('SUM(amount) as total'))
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

    return view('agent.earnings', compact('totalEarned', 'thisMonthEarned', 'dailyEarnings'));
}
  public function withdraw(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:500',
        'payment_method' => 'required|string',
        'phone_number' => 'required|string'
    ]);

    $user = Auth::user();
    $currentBalance = \App\Models\Transaction::where('user_id', $user->id)->sum('amount');

    if ($request->amount > $currentBalance) {
        return back()->with('error', 'Insufficient funds in your vault.');
    }

    // Create a negative transaction (pending withdrawal)
    \App\Models\Transaction::create([
        'user_id' => $user->id,
        'amount' => -$request->amount,
        'type' => 'withdrawal',
        'status' => 'pending',
        'meta' => [
            'method' => $request->payment_method,
            'phone' => $request->phone_number
        ]
    ]);

    return back()->with('success', 'Withdrawal request submitted for processing!');
}
}