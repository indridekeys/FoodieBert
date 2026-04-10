<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;         
use App\Models\Restaurant; 
use App\Models\Reservation;
use App\Models\Contact; 
use App\Models\Booking; 
use App\Notifications\RestaurantApplicationStatus; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Response; 
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * MAIN DASHBOARD VIEW
     */
    public function index()
    {
        $users = User::all();
        $restaurants = Restaurant::all();
        $restaurantCount = $restaurants->count();
        $reservations = Reservation::with('restaurant')->get();
        $contactMessages = Contact::latest()->get();
        $bookings = Booking::with(['restaurant', 'user'])->latest()->get();

        // Fetching pending applications
        $applications = DB::table('restaurant_applications')->where('status', 'pending')->get();
        
        return view('admin.dashboard', compact(
            'users', 
            'restaurants', 
            'restaurantCount', 
            'reservations',
            'contactMessages',
            'bookings',
            'applications'
        ));
    }

    /**
     * CONTACT MESSAGES & REPLIES
     */
    public function sendReply(Request $request)
    {
        $request->validate([
            'reply_content' => 'required|string',
            'recipient_email' => 'required|email',
            'message_id' => 'required|exists:contacts,id'
        ]);

        $details = [
            'subject' => 'RE: ' . ($request->original_subject ?? 'Restaurant Management'),
            'body' => $request->reply_content
        ];

        Mail::to($request->recipient_email)->send(new \App\Mail\ContactReplyMail($details));

        $contact = Contact::find($request->message_id);
        if ($contact) {
            $contact->update(['status' => 'replied', 'is_read' => true]);
        }

        return back()->with('success', 'Reply dispatched and message marked as read.');
    }

    public function markAsRead($id)
    {
        $msg = Contact::findOrFail($id);
        $msg->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }

    public function destroyMessage($id)
    {
        $msg = Contact::findOrFail($id);
        $msg->delete();
        return back()->with('success', 'Message removed from history.');
    }

    public function getMessageCount()
    {
        return response()->json([
            'count' => Contact::count(),
            'unread' => Contact::where('is_read', false)->count()
        ]);
    }

    /**
     * USER MANAGEMENT
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = strtolower($request->email); 
        $user->role = $request->role;
        $user->password = Hash::make('password123'); 

        if ($request->hasFile('profile_picture')) {
            $user->profile_picture = $request->file('profile_picture')->store('profiles', 'public');
        }

        $user->save();
        return back()->with('success', 'New citizen added to the registry.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'super_admin') return back()->with('error', 'The High Command is immutable.');

        if ($user->profile_picture) Storage::disk('public')->delete($user->profile_picture);
        $user->delete();
        return back()->with('success', 'User has been removed.');
    }

    /**
     * RESTAURANT MANAGEMENT (Manual Registration)
     */
    public function storeRestaurant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'owner_name' => 'required',
            'owner_email' => 'required|email|exists:users,email', 
            'location' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        $validated['owner_email'] = strtolower($request->owner_email);
        $validated['status'] = 'open'; // Synchronized for Online Badge

        $prefixMap = [
            'Fine Dining' => 'FB-FINE', 'Cafe' => 'FB-CAFE',
            'Casual Eateries' => 'FB-EAT', 'Snack Bars' => 'FB-SNACK/B',
            'Fast Food' => 'FB-FAST',
        ];

        $prefix = $prefixMap[$request->category] ?? 'FB-GEN'; 
        $count = Restaurant::where('category', $request->category)->count();
        $validated['matricule'] = $prefix . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant = Restaurant::create($validated);

        // Optional: Send manual registration email
        try {
            $pdf = Pdf::loadView('emails.restaurant_pdf', compact('restaurant'));
            Mail::send('emails.registration_notification', compact('restaurant'), function($message) use ($restaurant, $pdf) {
                $message->to($restaurant->owner_email)
                        ->subject('Registration Successful: ' . $restaurant->name)
                        ->attachData($pdf->output(), "Registration_{$restaurant->matricule}.pdf");
            });
        } catch (\Exception $e) {
            \Log::error("Mail failed: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Manual Registration Successful: ' . $validated['matricule']);
    }

    public function updateRestaurant(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'owner_name' => 'required|string',
            'owner_email' => 'required|email|exists:users,email',
            'location' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($restaurant->image_url) Storage::disk('public')->delete($restaurant->image_url);
            $validated['image_url'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant->update($validated);
        return redirect()->back()->with('success', 'Restaurant profile updated.');
    }

    public function destroyRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if ($restaurant->image_url) Storage::disk('public')->delete($restaurant->image_url);
        $restaurant->delete();
        return back()->with('success', 'Restaurant removed.');
    }

    /**
     * APPLICATION APPROVAL & REJECTION (Digital Applications)
     */
   // Approve Method
public function approve(Request $request, $id)
{
    $application = DB::table('restaurant_applications')->where('id', $id)->first();
    if (!$application) return back()->with('error', 'Application not found.');

    // 1. Determine Matricule Prefix
    $prefixMap = [
        'fine dining' => 'FB-FINE', 'cafe' => 'FB-CAFE',
        'casual eateries' => 'FB-EAT', 'snack bars' => 'FB-SNACK/B',
        'fast food' => 'FB-FAST',
    ];
    $prefix = $prefixMap[strtolower($application->category)] ?? 'FB-GEN'; 

    // 2. Generate Unique Sequential Matricule (THIS IS THE AUTO-GENERATION)
    $lastRes = Restaurant::where('matricule', 'LIKE', $prefix . '-%')->orderBy('matricule', 'desc')->first();
    $newNum = $lastRes ? ((int) substr($lastRes->matricule, strrpos($lastRes->matricule, '-') + 1)) + 1 : 1;
    $matricule = $prefix . '-' . str_pad($newNum, 3, '0', STR_PAD_LEFT);

    // 3. Create Official Restaurant
    $restaurant = Restaurant::create([
        'name' => $application->establishment_name,
        'owner_name' => $application->proprietor_name,
        'owner_email' => $application->owner_email,
        'location' => $application->location_address,
        'category' => $application->category,
        'description' => $application->description,
        'matricule' => $matricule, // The auto-generated matricule is saved here
        'image_url' => $application->image_path,
        'status' => 'open',
    ]);

    // 4. Send Notification (AUTOMATICALLY PASSING THE MATRICULE)
    $user = User::where('email', $application->owner_email)->first();
    if ($user) {
        $user->notify(new RestaurantApplicationStatus(
            'approved', 
            $application->establishment_name, 
            $matricule, // <--- Passing the variable from Step 2
            $request->admin_message // Custom feedback from your textarea
        ));
    }

    DB::table('restaurant_applications')->where('id', $id)->delete();
    return back()->with('success', "Approved! Matricule {$matricule} sent to owner.");
}

// Reject Method
public function reject(Request $request, $id) {
    $application = DB::table('restaurant_applications')->where('id', $id)->first();
    if ($application) {
        $user = User::where('email', $application->owner_email)->first();
        if ($user) {
            // Pass the custom message here too
            $user->notify(new RestaurantApplicationStatus(
                'rejected', 
                $application->establishment_name, 
                null, 
                $request->admin_message
            ));
        }

        DB::table('restaurant_applications')->where('id', $id)->delete();
    }
    
    return back()->with('success', 'Application rejected and owner notified via Gmail.');
}

    /**
     * OTHER UTILITIES
     */
    public function confirmReservation($id) {
        Booking::findOrFail($id)->update(['status' => 'confirmed']);
        return back()->with('success', 'Reservation confirmed.');
    }

    public function cancelReservation($id) {
        Booking::findOrFail($id)->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservation cancelled.');
    }

    public function exportUsers()
    {
        $users = User::all();
        $csvFileName = 'citizen_registry_' . date('Y-m-d') . '.csv';
        $headers = ["Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$csvFileName"];

        $callback = function() use($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Matricule', 'Name', 'Email', 'Role', 'Joined']);
            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->matricule ?? 'FB-USR-'.$user->id, $user->name, $user->email, $user->role, $user->created_at->format('Y-m-d')]);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }
}