<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Store multiple images for a specific restaurant.
     */
    public function store(Request $request, Restaurant $restaurant)
    {
        // Security Check: Ensure the logged-in owner actually owns this restaurant
        if ($restaurant->owner_email !== Auth::user()->email) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store in public/gallery/{restaurant_id}
                $path = $image->store('gallery/' . $restaurant->id, 'public');

                $restaurant->gallery()->create([
                    'path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Visual Feast updated!');
    }

    /**
     * Remove an image from the gallery.
     */
    public function destroy(Gallery $gallery)
    {
        // Security Check: Ensure the owner owns the restaurant this image belongs to
        if ($gallery->restaurant->owner_email !== Auth::user()->email) {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::disk('public')->exists($gallery->path)) {
            Storage::disk('public')->delete($gallery->path);
        }

        $gallery->delete();

        return back()->with('success', 'Image removed from catalog.');
    }
}