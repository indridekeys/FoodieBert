<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Added for professional file handling
use App\Models\Booking; 
use App\Models\Order;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\BookingStatusUpdated;

class OwnerController extends Controller
{
    public function index() 
    {
        $user = Auth::user();
        $restaurants = $user->restaurants;
        $restaurantIds = $restaurants->pluck('id');

        $bookings = Booking::whereIn('restaurant_id', $restaurantIds)
            ->with('restaurant')
            ->latest()
            ->get();

        $orders = Order::whereIn('restaurant_id', $restaurantIds)
            ->with(['user', 'restaurant', 'delivery_agent'])
            ->latest()
            ->get();

        $messages = Contact::whereIn('restaurant_id', $restaurantIds)->latest()->get();
        $menuItems = Menu::whereIn('restaurant_id', $restaurantIds)->with('restaurant')->get();
        
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
     * Store a new menu item.
     * UPDATED: Now supports 'ingredients' and uses the 'public' storage disk.
     */
      public function storeMenu(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'description' => 'nullable|string|max:500', // Changed from ingredients to description
        'restaurant_id' => 'required|exists:restaurants,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);

    $restaurant = Restaurant::findOrFail($request->restaurant_id);

    if ($restaurant->owner_email !== Auth::user()->email) {
        abort(403);
    }

    $data = [
        'name'          => $request->name,
        'price'         => $request->price,
        'description'   => $request->description, // Matches Model
        'restaurant_id' => $request->restaurant_id,
        'is_available'  => true,
    ];

    if ($request->hasFile('image')) {
        // Saves to storage/app/public/menus
        $path = $request->file('image')->store('menus', 'public');
        $data['image'] = $path;
    }

    Menu::create($data);

    return redirect()->back()->with('success', 'New dish added!');
}

    /**
     * Delete a menu item.
     * UPDATED: Corrected to delete from Storage disk.
     */
    public function destroyMenu($id)
    {
        $menuItem = Menu::findOrFail($id);
        
        if ($menuItem->restaurant->owner_email !== Auth::user()->email) {
            abort(403);
        }

        // Delete image from storage
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();
        return redirect()->back()->with('success', 'Dish removed from menu.');
    }

    // --- Order & Booking Methods (Kept as provided, they are functional) ---

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,cooking,preparing,ready,delivering,delivered']);
        $order = Order::findOrFail($id);
        if ($order->restaurant->owner_email !== Auth::user()->email) abort(403);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function acceptOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->restaurant->owner_email !== Auth::user()->email) abort(403);
        $order->update(['status' => 'preparing']);
        return redirect()->back()->with('success', 'Order Accepted! Move to preparation.');
    }

    public function rejectOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->restaurant->owner_email !== Auth::user()->email) abort(403);
        $order->update(['status' => 'rejected']);
        return redirect()->back()->with('error', 'Order has been rejected.');
    }

    public function assignAgent(Request $request, $id)
    {
        $request->validate(['delivery_agent_name' => 'required|string|max:255']);
        $order = Order::findOrFail($id);
        if ($order->restaurant->owner_email !== Auth::user()->email) abort(403);
        $order->update(['agent_id' => $request->delivery_agent_name, 'status' => 'delivering']);
        return redirect()->back()->with('success', 'Agent assigned. Food is out for delivery!');
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled', 'recommendation' => 'nullable|string|max:500']);
        $booking = Booking::with('user', 'restaurant')->findOrFail($id);
        if ($booking->restaurant->owner_email !== Auth::user()->email) abort(403);
        $booking->update(['status' => $request->status]);
        if ($booking->user) $booking->user->notify(new BookingStatusUpdated($booking, $request->recommendation));
        return redirect()->back()->with('success', 'Booking status updated!');
    }

    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->restaurant->owner_email !== Auth::user()->email) abort(403);
        $booking->delete();
        return redirect()->back()->with('success', 'Booking deleted.');
    }

    public function updateProfile(Request $request)
    {
        $request->validate(['profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
        $user = Auth::user();
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) Storage::disk('public')->delete($user->profile_photo);
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->update(['profile_photo' => $path]);
        }
        return back()->with('success', 'Profile photo updated!');
    }
}