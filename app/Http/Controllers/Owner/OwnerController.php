<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Menu;

class OwnerController extends Controller
{
    public function index() 
{
    $user = Auth::user();

    // Use null coalescing or ensure the relationship is called as a property
    $restaurants = $user->restaurants ?? collect(); 
    $restaurantIds = $restaurants->pluck('id');

    return view('owner.dashboard', [
        'restaurants'  => $restaurants,
        'bookings'     => Reservation::whereIn('restaurant_id', $restaurantIds)->latest()->get(),
        'orders'       => Order::whereIn('restaurant_id', $restaurantIds)->latest()->get(),
        'messages'     => Contact::whereIn('restaurant_id', $restaurantIds)->latest()->get(),
        'menuItems'    => Menu::whereIn('restaurant_id', $restaurantIds)->get(),
        'cookingCount' => Order::whereIn('restaurant_id', $restaurantIds)
                                ->where('status', 'cooking')
                                ->count()
    ]);
}

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,cooking,ready,delivered'
        ]);

        $order = Order::findOrFail($id);

        if ($order->restaurant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated!');
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();

    if ($request->hasFile('profile_photo')) {
        // Delete old photo if it exists (optional but clean)
        if ($user->profile_photo && file_exists(public_path($user->profile_photo))) {
            unlink(public_path($user->profile_photo));
        }

        $file = $request->file('profile_photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profiles'), $filename);
        
        // Save the path to the database
        $user->profile_photo = 'uploads/profiles/' . $filename;
        $user->save();
    }

    return back()->with('success', 'Profile photo updated successfully!');
}
}