<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'matricule',
        'profile_photo', 
        'verification_code',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * The "booted" method of the model.
     * Logic for automatic matricule and verification code generation.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            // 1. Generate 6-digit Verification Code
            $user->verification_code = (string) rand(100000, 999999);

            // 2. Generate Matricule only if it's not manually set (like your Super Admin)
            if (!$user->matricule) {
                $prefixes = [
                    'super_admin' => 'FB-SA-',
                    'admin'       => 'FB-OWN-',
                    'delivery'    => 'FB-AGT-',
                    'customer'    => 'FB-CUS-',
                ];

                $prefix = $prefixes[$user->role] ?? 'FB-USR-';

                // Get the last user with this specific role to determine the next number
                $lastUser = static::where('role', $user->role)
                    ->where('matricule', 'like', $prefix . '%')
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$lastUser) {
                    $number = 1;
                } else {
                    // Extract the numeric part from the last matricule (e.g., FB-CUS-01 -> 1)
                    $lastNumber = (int) substr($lastUser->matricule, strrpos($lastUser->matricule, '-') + 1);
                    $number = $lastNumber + 1;
                }

                // Format: FB-CUS-01, FB-CUS-02, etc.
                $user->matricule = $prefix . str_pad($number, 2, '0', STR_PAD_LEFT);
            }
        });

        
    }

    // app/Models/User.php

    public function restaurants(): HasMany
    {
        return $this->hasMany(Restaurant::class);
    }

public function orders() {
    return $this->hasMany(Order::class, 'agent_id');
}

public function transactions() {
    return $this->hasMany(Transaction::class);
}
}