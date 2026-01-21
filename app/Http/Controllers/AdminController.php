<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'restaurantCount' => 0, 
            'userCount' => User::count(),
            'partnerCount' => User::whereIn('role', ['restaurant_owner', 'delivery_agent'])->count(),
            'restaurants' => [], 
            'users' => User::all(),
        ]);
    }

    public function updateProfile(Request $request) 
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists
            if ($user->profile_photo_path) {
                Storage::delete('public/' . $user->profile_photo_path);
            }

            // Store the new file
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            
            // We save it to 'profile_photo_path' to match standard Laravel naming
            $user->profile_photo_path = $path; 
        }
        
        $user->save();
        return back()->with('success', 'Your imperial profile has been updated!');
    }
}