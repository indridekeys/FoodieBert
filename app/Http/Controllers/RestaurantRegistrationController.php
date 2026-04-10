<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;         
use App\Models\Restaurant; 
use App\Models\Contact; 
use App\Notifications\RestaurantApplicationStatus; 
use Illuminate\Support\Str;

class RestaurantRegistrationController extends Controller
{
    /**
     * Show the application form.
     */
    public function create()
    {
        return view('register.restaurant');
    }

    /**
     * Store the application in the system for Admin review.
     */
    public function store(Request $request)
    {
        $request->validate([
            'establishment_name' => 'required|string|max:255',
            'proprietor_name'    => 'required|string|max:255',
            'owner_email'        => 'required|email',
            'location_address'   => 'required|string',
            'category'           => 'required|string',
            'description'        => 'required|string',
            'image'              => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $imagePath = null;

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('applications', 'public');
            }

            DB::table('restaurant_applications')->insert([
                'establishment_name' => $request->establishment_name,
                'proprietor_name'    => $request->proprietor_name,
                'owner_email'        => $request->owner_email,
                'location_address'   => $request->location_address,
                'category'           => $request->category,
                'description'        => $request->description,
                'image_path'         => $imagePath, 
                'status'             => 'pending', 
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            return back()->with('success', 'Application submitted! Please check your Gmail for further updates.');

        } catch (\Exception $e) {
            Log::error('Restaurant Registration Error: ' . $e->getMessage());

            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            return back()->withInput()->withErrors(['error' => 'An error occurred. Please try again later.']);
        }
    }

    /**
     * Admin Dashboard: Approve the application
     */
    public function approve(Request $request, $id) 
    {
        $application = DB::table('restaurant_applications')->where('id', $id)->first();

        if (!$application) {
            return back()->withErrors(['error' => 'Application not found.']);
        }

        // 1. Determine Prefix
        $prefixMap = [
            'fine dining'     => 'FB-FINE',
            'cafe'            => 'FB-CAFE',
            'casual eateries' => 'FB-EAT',
            'snack bars'      => 'FB-SNACK/B',
            'fast food'       => 'FB-FAST',
        ];
        
        $catKey = strtolower($application->category);
        $prefix = $prefixMap[$catKey] ?? 'FB-GEN'; 

        // 2. Generate Unique Sequential Matricule
        $lastRestaurant = Restaurant::where('matricule', 'LIKE', $prefix . '-%')
            ->orderBy('matricule', 'desc')
            ->first();

        $newNumber = $lastRestaurant ? ((int) substr($lastRestaurant->matricule, strrpos($lastRestaurant->matricule, '-') + 1)) + 1 : 1;
        $matricule = $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // 3. Generate a Unique Slug using the Matricule to prevent slug conflicts
        $slug = Str::slug($application->establishment_name . '-' . $matricule);

        // 4. START TRANSACTION
        DB::transaction(function () use ($application, $matricule, $slug, $id, $request) {
            
            // Create actual Restaurant record
            $restaurant = Restaurant::create([
                'name'         => $application->establishment_name,
                'category'     => $application->category,
                'location'     => $application->location_address,
                'description'  => $application->description,
                'image_url'    => $application->image_path, 
                'matricule'    => $matricule,
                'owner_name'   => $application->proprietor_name,
                'owner_email'  => $application->owner_email,
                'slug'         => $slug, 
                'status'       => 'open',
            ]);

            // Save Admin Feedback for the OWNER'S Dashboard
            // We explicitly link it to the newly created restaurant's ID
            Contact::create([
                'restaurant_id' => $restaurant->id, 
                'name'          => 'FoodieBert Admin',
                'email'         => 'admin@foodiebert.com',
                'subject'       => 'Welcome to FoodieBert: ' . $restaurant->name,
                'message'       => $request->admin_message ?? "Your establishment has been officially approved. Your matricule is $matricule.",
            ]);

            // Update application status
            DB::table('restaurant_applications')->where('id', $id)->update([
                'status' => 'approved',
                'updated_at' => now()
            ]);
        });

        // 5. Notify the user via Gmail
        $user = User::where('email', $application->owner_email)->first();
        if ($user) {
            $user->notify(new RestaurantApplicationStatus(
                'approved', 
                $application->establishment_name, 
                $matricule, 
                $request->admin_message
            ));
        }

        return back()->with('success', "Approved! Matricule $matricule assigned and message sent to owner.");
    }

    /**
     * Admin Dashboard: Reject/Delete the application
     */
    public function reject(Request $request, $id)
    {
        $application = DB::table('restaurant_applications')->where('id', $id)->first();

        if ($application) {
            // Notify user of rejection + reason via Gmail
            $user = User::where('email', $application->owner_email)->first();
            if ($user) {
                $user->notify(new RestaurantApplicationStatus(
                    'rejected', 
                    $application->establishment_name, 
                    null, 
                    $request->admin_message
                ));
            }

            // Delete image file if it exists
            if ($application->image_path) {
                Storage::disk('public')->delete($application->image_path);
            }

            DB::table('restaurant_applications')->where('id', $id)->delete();
            return back()->with('success', 'Application rejected and owner notified.');
        }

        return back()->withErrors(['error' => 'Application not found.']);
    }

    public function index() 
    {
        $applications = DB::table('restaurant_applications')
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.registrations.index', compact('applications'));
    }
}