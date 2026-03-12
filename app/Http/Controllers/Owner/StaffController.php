<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function store(Request $request, Restaurant $restaurant)
    {
        // Security check
        if ($restaurant->owner_email !== Auth::user()->email) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('staff/' . $restaurant->id, 'public');
        }

        $restaurant->staff()->create([
            'name' => $request->name,
            'position' => $request->position,
            'photo' => $path,
        ]);

        return back()->with('success', 'New team member added to the roster!');
    }

    public function destroy(Staff $staff)
    {
        // Security check via the relationship
        if ($staff->restaurant->owner_email !== Auth::user()->email) {
            abort(403);
        }

        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }

        $staff->delete();
        return back()->with('success', 'Staff member removed.');
    }
}