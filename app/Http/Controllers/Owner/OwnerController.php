<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; 
use App\Models\Order;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Notifications\BookingStatusUpdated;

class OwnerController extends Controller
{
    /**
     * Display the Owner Dashboard.
     * Uses Matricule-based relationships for reliability.
     */
    public function index() 
    {
        $user = Auth::user();

        // 1. Fetch restaurants via the relationship defined in User.php
        $restaurants = $user->restaurants;
        
        // 2. Get IDs for precise filtering
        $restaurantIds = $restaurants->pluck('id');

        // 3. Fetch all bookings for these restaurants
        $bookings = Booking::whereIn('restaurant_id', $restaurantIds)
            ->with('restaurant')
            ->latest()
            ->get();

        // 4. Fetch all orders for these restaurants
        $orders = Order::whereIn('restaurant_id', $restaurantIds)
            ->with(['user', 'restaurant'])
            ->latest()
            ->get();

        // 5. Filter messages and menu items
        $messages = Contact::whereIn('restaurant_id', $restaurantIds)->latest()->get();
        $menuItems = Menu::whereIn('restaurant_id', $restaurantIds)->with('restaurant')->get();
        
        // 6. Kitchen Stats
        $cookingCount = $orders->where('status', 'cooking')->count();

        return view('owner.dashboard', [
            'restaurants'  => $restaurants,
            'bookings'     => $bookings,
            'orders'       => $orders,
            'messages'     => $messages,
            'menuItems'    => $menuItems,
            'cookingCount' => $cookingCount
        ]);
    }

    /**
     * Update order status with security check.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,cooking,ready,delivered'
        ]);

        $order = Order::findOrFail($id);
        $user = Auth::user();

        // SECURITY: Verify ownership via matricule or email
        if ($order->restaurant->owner_matricule !== $user->matricule && $order->restaurant->owner_email !== $user->email) {
            abort(403, 'Unauthorized action.');
        }

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Update booking (reservation) status with Notification and Recommendation logic.
     */
    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'recommendation' => 'nullable|string|max:500' 
        ]);

        $booking = Booking::with('user', 'restaurant')->findOrFail($id);
        $user = Auth::user();

        // SECURITY: Check ownership
        if ($booking->restaurant->owner_matricule !== $user->matricule && $booking->restaurant->owner_email !== $user->email) {
            abort(403, 'Unauthorized action.');
        }

        // Update status
        $booking->update(['status' => $request->status]);

        // Notify the Customer (the user who made the booking)
        if ($booking->user) {
            $booking->user->notify(new BookingStatusUpdated($booking, $request->recommendation));
        }

        $msg = $request->status == 'cancelled' ? 'Booking declined and recommendation sent.' : 'Booking confirmed!';
        
        return redirect()->back()->with('success', $msg);
    }

    /**
     * NEW: Delete a booking (reservation) permanently.
     */
    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        // SECURITY: Check ownership
        if ($booking->restaurant->owner_matricule !== $user->matricule && $booking->restaurant->owner_email !== $user->email) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }

    /**
     * Store a new menu item.
     */
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'restaurant_id' => 'required|exists:restaurants,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $restaurant = Restaurant::findOrFail($request->restaurant_id);

        // Check if the owner actually owns this restaurant
        if ($restaurant->owner_matricule !== Auth::user()->matricule && $restaurant->owner_email !== Auth::user()->email) {
            abort(403);
        }

        $data = $request->only(['name', 'price', 'restaurant_id']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menus'), $filename);
            $data['image'] = 'uploads/menus/' . $filename;
        }

        Menu::create($data);

        return redirect()->back()->with('success', 'New dish added to the menu!');
    }

    /**
     * Delete a menu item.
     */
    public function destroyMenu($id)
    {
        $menuItem = Menu::findOrFail($id);
        
        // Security check
        if ($menuItem->restaurant->owner_matricule !== Auth::user()->matricule) {
            abort(403);
        }

        // Delete image file if exists
        if ($menuItem->image && file_exists(public_path($menuItem->image))) {
            @unlink(public_path($menuItem->image));
        }

        $menuItem->delete();
        return redirect()->back()->with('success', 'Dish removed from menu.');
    }

    /**
     * Update the owner's profile picture.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
                @unlink(public_path($user->profile_photo));
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profiles'), $filename);
            
            $user->profile_photo = 'uploads/profiles/' . $filename;
            $user->save();
        }

        return back()->with('success', 'Profile photo updated successfully!');
    }
}