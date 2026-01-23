<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller; // Ensure this file exists!
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    /**
     * Handle Account Registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,delivery,customer',
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'profile_photo' => $photoPath,
            'is_verified' => false,
        ]);

        // SEND EMAIL HERE - Before the return statement
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user));
        } catch (\Exception $e) {
            // Log error but don't crash the whole registration
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful. Check your email for code.',
            'data' => [
                'matricule' => $user->matricule,
                'email' => $user->email,
            ]
        ], 201);
    }

    /**
     * Handle Verification Code Check
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->code)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code or email.'], 422);
        }

        $user->update([
            'is_verified' => true,
            'verification_code' => null, 
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Account verified successfully! You can now log in.',
            'matricule' => $user->matricule
        ]);
    }
}