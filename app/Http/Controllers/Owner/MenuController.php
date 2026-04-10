<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        // If you applied the Trait to the Menu model, 
        // this will automatically filter by owner!
        $menuItems = Menu::latest()->get();
        return view('owner.menus.index', compact('menuItems'));
    }

    public function create()
    {
        $restaurants = Auth::user()->restaurants;
        return view('owner.menus.create', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        Menu::create($request->all());

        return redirect()->route('owner.menus.index')->with('success', 'Menu created!');
    }

    public function destroy($id)
{
    $menuItem = \App\Models\Menu::findOrFail($id);
    
    // Security check
    if ($menuItem->restaurant->owner_email !== auth()->user()->email) {
        abort(403);
    }

    // Delete image from storage if it exists
    if ($menuItem->image) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($menuItem->image);
    }

    $menuItem->delete();
    return redirect()->back()->with('success', 'Dish removed successfully.');
}
}