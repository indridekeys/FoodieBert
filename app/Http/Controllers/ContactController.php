<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\AdminReply; // Import the Mailable you created
use Illuminate\Support\Facades\Mail; // Import the Mail facade

class ContactController extends Controller
{
    /**
     * Store an incoming message from the contact form.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($data);

        return back()->with('success', 'Thanks for reaching out!');
    }

    /**
     * Send a reply to the citizen via email.
     */
   public function reply(Request $request)
{
    $request->validate([
        'recipient_email' => 'required|email',
        'reply_content' => 'required|string',
        'original_subject' => 'required|string',
        'message_id' => 'required|exists:contacts,id',
    ]);

    try {
        // Send the email
        Mail::to($request->recipient_email)->send(new AdminReply(
            $request->reply_content, 
            $request->original_subject
        ));

        // Update the database status
        Contact::where('id', $request->message_id)->update(['status' => 'replied']);

        return back()->with('success', 'Reply sent and message marked as replied!');
        
    } catch (\Exception $e) {
        return back()->with('error', 'Mail failed: ' . $e->getMessage());
    }
}
}