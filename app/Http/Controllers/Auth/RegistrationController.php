<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showVerifyPage()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    /**
     * Handle user registration and generate Role-Specific Matricule.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,agent,owner,customer',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Generate 6-Digit OTP
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // 2. Generate Unique Matricule (Restarts at 001 for EACH role)
        // We map the roles to your specific 4-letter codes
        $roleMapping = [
            'admin'    => 'ADMN',
            'agent'    => 'AGEN',
            'owner'    => 'OWNR',
            'customer' => 'CUST',
        ];

        $roleCode = $roleMapping[$request->role] ?? 'USER';

        // Critical Fix: Count ONLY users with the same role
        $countInRole = User::where('role', $request->role)->count();
        $sequence = str_pad($countInRole + 1, 3, '0', STR_PAD_LEFT);

        // Format: FB-CUST-001
        $matricule = 'FB-' . $roleCode . '-' . $sequence;

        // 3. Handle Profile Photo Upload
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profiles', 'public');
        }

        // 4. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'matricule' => $matricule,
            'profile_photo' => $photoPath,
            'is_verified' => false,
            'verification_code' => $verificationCode,
        ]);

        // 5. Send Email via Gmail SMTP
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user));
        } catch (\Exception $e) {
            Log::error("Mail failed to send to " . $user->email . ": " . $e->getMessage());
        }

        // 6. Log the user in and redirect to verify page
        Auth::login($user);

        return redirect()->route('verify.page')->with('success', 'Registration successful! Your Matricule is: ' . $matricule);
    }

    /**
     * Verify OTP and Redirect to role-specific dashboard.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6', 
        ]);

        $user = User::where('email', $request->email)
                    ->where('verification_code', $request->otp)
                    ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid verification code.']);
        }

        // Update verification status
        $user->update([
            'is_verified' => true,
            'verification_code' => null, 
        ]);

        // Smart Redirection based on role
        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard')->with('success', 'Admin Access Verified.'),
            'agent'    => redirect()->route('agent.dashboard')->with('success', 'Agent Access Verified.'),
            'owner'    => redirect()->route('owner.dashboard')->with('success', 'Owner Access Verified.'),
            'customer' => redirect()->route('customer.dashboard')->with('success', 'Customer Access Verified.'),
            default    => redirect()->route('home'),
        };
    }

    /**
     * Resend verification code.
     */
    public function resend(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('register');

        $newCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update(['verification_code' => $newCode]);

        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user));
            return back()->with('success', 'A fresh code has been sent to your Gmail.');
        } catch (\Exception $e) {
            return back()->with('error', 'Mail error: ' . $e->getMessage());
        }
    }

    /**
     * Delete user (Admin only).
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id() || $user->role === 'admin') {
            return back()->with('error', 'Action denied.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}