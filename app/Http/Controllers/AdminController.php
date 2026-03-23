<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;        
use App\Models\Restaurant; 
use App\Models\Reservation;
use App\Models\Contact; 
// Added missing model import to fix the "Class not found" error
use App\Models\Booking; 
use App\Mail\AdminReplyMail; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Response; 
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * MAIN DASHBOARD VIEW
     * Fixed: Removed early return and added proper data compacting
     */
    public function index()
    {
        $users = User::all();
        $restaurants = Restaurant::all();
        $restaurantCount = $restaurants->count();
        $reservations = Reservation::with('restaurant')->get();
        $contactMessages = Contact::latest()->get();
        
        // High performance fetching for the new booking system
        $bookings = Booking::with(['restaurant', 'user'])->latest()->get();
        
        // Combined all data into a single view return
        return view('admin.dashboard', compact(
            'users', 
            'restaurants', 
            'restaurantCount', 
            'reservations',
            'contactMessages',
            'bookings'
        ));
    }

    /**
     * Handle the message reply and update message status
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

        // Send the email
        Mail::to($request->recipient_email)->send(new \App\Mail\ContactReplyMail($details));

        // Update record
        $contact = Contact::find($request->message_id);
        if ($contact) {
            $contact->update([
                'status' => 'replied',
                'is_read' => true
            ]);
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

    /**
     * REAL-TIME API METHODS
     */
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
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make('password123'); 

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->profile_picture = $path;
        }

        $user->save();
        return back()->with('success', 'New citizen added to the registry.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'super_admin') {
            return back()->with('error', 'The High Command is immutable.');
        }

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();
        return back()->with('success', 'User has been removed from the system.');
    }

    /**
     * RESTAURANT MANAGEMENT
     */
    public function storeRestaurant(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'owner_name' => 'required',
            'owner_email' => 'required|email', 
            'location' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        // Auto-generate Matricule based on category
        $prefixMap = [
            'Fine Dining'     => 'FB-FINE',
            'Cafe'            => 'FB-CAFE',
            'Casual Eateries' => 'FB-EAT',
            'Snack Bars'      => 'FB-SNACK/B',
            'Fast Food'       => 'FB-FAST',
        ];

        $prefix = $prefixMap[$request->category] ?? 'FB-GEN'; 
        $count = Restaurant::where('category', $request->category)->count();
        $sequence = str_pad($count + 1, 3, '0', STR_PAD_LEFT); 
        $validated['matricule'] = $prefix . '-' . $sequence;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('restaurants', 'public');
            $validated['image_url'] = $path;
        }

        $restaurant = Restaurant::create($validated);

        // Notify Owner with PDF
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

        return redirect()->back()->with('success', 'Registered with Matricule: ' . $validated['matricule']);
    }

    /**
     * BOOKING/RESERVATION STATUS CONTROL
     */
    public function confirmReservation($id) {
        // Works for both Reservation and Booking models if they share the status field
        $res = Booking::findOrFail($id);
        $res->update(['status' => 'confirmed']);
        return back()->with('success', 'Reservation confirmed and locked.');
    }

    public function cancelReservation($id) {
        $res = Booking::findOrFail($id);
        $res->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservation has been cancelled.');
    }

    public function exportUsers()
    {
        $users = User::all();
        $csvFileName = 'citizen_registry_' . date('Y-m-d') . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
        ];

        $callback = function() use($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Matricule', 'Name', 'Email', 'Role', 'Joined']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->matricule ?? 'FB-USR-'.$user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}