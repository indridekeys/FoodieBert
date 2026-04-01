<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Models\Restaurant;
use App\Models\Review;

class DashboardController extends Controller
{
    /**
     * The main entry point for /dashboard.
     * It redirects users to their specific role-based dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/');
        }

        // Traffic Controller logic
        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'agent'    => redirect()->route('agent.dashboard'),
            'owner'    => redirect()->route('owner.dashboard'),
            'customer' => $this->customerDashboard(), // Loads the view directly
            default    => redirect('/'),
        };
    }

    /**
     * Logic for the Customer Dashboard view.
     */
    protected function customerDashboard()
    {
        $user = Auth::user();

        // 1. Upcoming Reservations (Mapped for all possible variable names in Blade)
        $activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('restaurant')
            ->latest()
            ->get();

        // 2. History (Mapped to $pastBookings and $history for line 215)
        $pastBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'cancelled', 'rejected'])
            ->with(['restaurant', 'review']) 
            ->latest()
            ->limit(10)
            ->get();

        // 3. Stats
        $totalVisits = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $reviewCount = Review::where('user_id', $user->id)->count();
        $points = 1240 + ($totalVisits * 100) + ($reviewCount * 50);

        // 4. Favorites / Suggestions
        $suggestedRestaurants = Restaurant::limit(4)->get();

        // 5. Profile Photo Logic
        $photoUrl = $user->profile_photo 
            ? asset($user->profile_photo) 
            : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=064e3b&color=d4af37';

        /**
         * We pass both the new elegant names and the legacy names 
         * to prevent "Undefined variable" errors in different parts of your Blade file.
         */
        return view('customer.dashboard', [
            // New Names
            'activeBookings'       => $activeBookings,
            'pastBookings'         => $pastBookings,
            'suggestedRestaurants' => $suggestedRestaurants,
            
            // Legacy/Alias Names (Required for your specific Blade lines 132 and 215)
            'bookings'             => $activeBookings, 
            'history'              => $pastBookings,
            'favorites'            => $suggestedRestaurants,
            
            // Stats & UI
            'totalVisits'          => $totalVisits,
            'reviewCount'          => $reviewCount,
            'points'               => $points,
            'photoUrl'             => $photoUrl
        ]);
    }

    /**
     * NEW: Handle Profile Photo Update from the Emerald Modal
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                @unlink(public_path($user->profile_photo));
            }

            $file = $request->file('profile_photo');
            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Ensure the directory exists: public/uploads/profiles
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