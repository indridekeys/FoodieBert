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

            // 2. Generate Matricule only if it's not manually set
            if (!$user->matricule) {
                $prefixes = [
                    'super_admin' => 'FB-SA-',
                    'admin'       => 'FB-OWN-',
                    'delivery'    => 'FB-AGT-',
                    'customer'    => 'FB-CUS-',
                ];

                $prefix = $prefixes[$user->role] ?? 'FB-USR-';

                $lastUser = static::where('role', $user->role)
                    ->where('matricule', 'like', $prefix . '%')
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$lastUser) {
                    $number = 1;
                } else {
                    $lastNumber = (int) substr($lastUser->matricule, strrpos($lastUser->matricule, '-') + 1);
                    $number = $lastNumber + 1;
                }

                $user->matricule = $prefix . str_pad($number, 2, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Relationship: Linked Restaurants
     * This connects the User to Restaurants via their Email address.
     */
    public function restaurants(): HasMany
    {
        // 'owner_email' is the column in the restaurants table
        // 'email' is the column in this (users) table
        return $this->hasMany(Restaurant::class, 'owner_email', 'email');
    }

    /**
     * Relationship: Orders assigned to this user (as an agent).
     */
    public function orders(): HasMany 
    {
        return $this->hasMany(Order::class, 'agent_id');
    }

    /**
     * Relationship: User Transactions.
     */
    public function transactions(): HasMany 
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Relationship: Bookings made by this user (as a customer).
     */
    public function bookings(): HasMany 
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}