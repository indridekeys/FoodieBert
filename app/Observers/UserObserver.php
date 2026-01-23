<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
     public function creating(User $user) {
    // 1. Generate Verification Code
    $user->verification_code = rand(100000, 999999);

    // 2. Generate Matricule (Skip if it's the seeded Super Admin)
    if (!$user->matricule) {
        $prefixes = [
            'admin' => 'FB-OWN-',
            'delivery' => 'FB-AGT-',
            'customer' => 'FB-CUS-',
        ];

        $prefix = $prefixes[$user->role] ?? 'FB-USR-';
        
        // Count existing users with this prefix to get the next number
        $count = User::where('role', $user->role)->count() + 1;
        $user->matricule = $prefix . str_pad($count, 2, '0', STR_PAD_LEFT);
    }
}
    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
