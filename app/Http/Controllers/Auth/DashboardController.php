<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Models\Order; // <--- ADDED THIS
use App\Models\Restaurant;
use App\Models\Review;

class DashboardController extends Controller
{
    /**
     * The main entry point for /dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'agent'    => redirect()->route('agent.dashboard'),
            'owner'    => redirect()->route('owner.dashboard'),
            'customer' => $this->customerDashboard(),
            default    => redirect('/'),
        };
    }

    /**
     * Logic for the Customer Dashboard view.
     */
    protected function customerDashboard()
    {
        $user = Auth::user();

        // 1. Upcoming Reservations
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('restaurant')
            ->latest()
            ->get();

        // 2. History
        $pastBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'rejected'])
            ->with(['restaurant', 'review']) 
            ->latest()
            ->limit(10)
            ->get();

        // 3. NEW: Fetch Food Orders for the tracking section
        $orders = Order::where('user_id', $user->id)
            ->with('restaurant')
            ->latest()
            ->get();

        // 4. Stats
        $totalVisits = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $reviewCount = Review::where('user_id', $user->id)->count();
        $points = 1240 + ($totalVisits * 100) + ($reviewCount * 50);

        // 5. Favorites / Suggestions
        $suggestedRestaurants = Restaurant::limit(4)->get();

        // 6. Profile Photo Logic
        $photoUrl = $user->profile_photo 
            ? asset($user->profile_photo) 
            : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=064e3b&color=d4af37';

        return view('customer.dashboard', [
            'activeBookings'       => $activeBookings,
            'pastBookings'         => $pastBookings,
            'orders'               => $orders, // <--- ADDED THIS FOR YOUR TABLE
            'suggestedRestaurants' => $suggestedRestaurants,
            
            // Legacy/Alias Names
            'bookings'             => $activeBookings, 
            'history'              => $pastBookings,
            'favorites'            => $suggestedRestaurants,
            
            // Stats & UI
            'totalVisits'          => $totalVisits,
            'reviewCount'          => $reviewCount,
            'points'               => $points,
            'photoUrl'             => $photoUrl,
            'favRestaurant'        => $suggestedRestaurants->first()->name ?? 'Explore Bertoua'
        ]);
    }

    /**
     * Handle Profile Photo Update
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                @unlink(public_path($user->profile_photo));
            }

            $file = $request->file('profile_photo');
            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/profiles'))) {
                mkdir(public_path('uploads/profiles'), 0777, true);
            }
            
            $file->move(public_path('uploads/profiles'), $fileName);
            
            $user->profile_photo = 'uploads/profiles/' . $fileName;
            $user->save();
        }

        return back()->with('success', 'Your profile has been updated elegantly.');
    }
}