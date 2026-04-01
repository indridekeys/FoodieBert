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
    public function acceptOrder($id) 
    {
        $order = Order::findOrFail($id);

        // Prevent double-claiming
        if ($order->agent_id !== null) {
            return back()->with('error', 'This mission has already been claimed by another agent.');
        }

        $order->update([
            'agent_id' => Auth::id(),
            'status'   => 'picked_up', // Moves it to the "Current Mission" section
        ]);

        return back()->with('success', 'Mission accepted! Check your Current Mission for details.');
    }

    /**
     * Agent completes the mission and triggers payout
     */
    public function completeOrder($id) // Renamed to match your route: agent.orders.complete
    {
        $order = Order::where('id', $id)
                      ->where('agent_id', Auth::id())
                      ->where('status', 'picked_up')
                      ->firstOrFail();

        try {
            DB::transaction(function () use ($order) {
                // 1. Update order status to delivered
                $order->update(['status' => 'delivered']);

                // 2. Create the payout record
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
     * Matches the JS fetch call to route('agent.toggle-status')
     */
    public function toggleAvailability(Request $request) 
    {
        // Accept the boolean from your JSON body
        $isAvailable = $request->input('is_available');

        $user = Auth::user();
        
        try {
            $user->is_available = $isAvailable;
            $user->save();

            return response()->json([
                'status'    => 'success',
                'message'   => $user->is_available ? 'You are now online' : 'You are now offline',
                'is_online' => (bool)$user->is_available
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Earnings Overview
     */
    public function earnings()
    {
        $user = Auth::user();
        
        $totalEarned = Transaction::where('user_id', $user->id)
            ->where('type', 'delivery_fee')
            ->sum('amount');

        $thisMonthEarned = Transaction::where('user_id', $user->id)
            ->where('type', 'delivery_fee')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $dailyEarnings = Transaction::where('user_id', $user->id)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('agent.earnings', compact('totalEarned', 'thisMonthEarned', 'dailyEarnings'));
    }

    /**
     * Withdrawal Logic
     */
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'payment_method' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        $user = Auth::user();
        // Calculate balance: Sum of delivery fees minus sum of withdrawals
        $currentBalance = Transaction::where('user_id', $user->id)->sum('amount');

        if ($request->amount > $currentBalance) {
            return back()->with('error', 'Insufficient funds in your vault.');
        }

        Transaction::create([
            'user_id' => $user->id,
            'amount'  => -$request->amount,
            'type'    => 'withdrawal',
            'status'  => 'pending',
            // Ensure your 'meta' column is cast to array/json in the Transaction Model
            'meta'    => json_encode([
                'method' => $request->payment_method,
                'phone'  => $request->phone_number
            ])
        ]);

        return back()->with('success', 'Withdrawal request submitted for processing!');
    }
}