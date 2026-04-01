<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;


class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'name',
        'slug',
        'category',
        'owner_name',
        'owner_email', // The "bridge" to the User
        'location',
        'description',
        'image_url',
        'logo_url',
        'cover_image'
    ];

    /**
     * Boot function to automatically generate a slug from the name.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($restaurant) {
            if (empty($restaurant->slug)) {
                $restaurant->slug = Str::slug($restaurant->name);
            }
        });
    }

    /**
     * Relationship: The User (Owner) who owns this restaurant.
     * Linked via the owner_email field.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_email', 'email');
    }

    /**
     * Relationship: The Visual Feast (Gallery).
     * Used in your dashboard as $res->gallery.
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Relationship: Menu items/dishes.
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Relationship: Active Delivery Orders.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relationship: Table Reservations.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relationship: Staff members.
     */
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    public function galleries()
{
    // If your gallery table has a restaurant_id column
    return $this->hasMany(Gallery::class); 
    
    // Note: If your model is named RestaurantGallery, use:
    // return $this->hasMany(RestaurantGallery::class);
}

    /**
     * Relationship: Blog posts or updates.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}