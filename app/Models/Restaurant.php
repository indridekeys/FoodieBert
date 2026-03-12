<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'name',
        'slug',        // Added for the Picker/Redirection
        'category',
        'owner_name',
        'owner_email',
        'location',
        'description',
        'image_url',
        'logo_url',    // Added for the Picker UI
        'cover_image'  // Added for the Landing Page Hero
    ];

    /**
     * Boot function to automatically generate a slug from the name
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

    public function gallery(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(Gallery::class);
}

    /**
     * Get the menus for the restaurant.
     * This fixes the "foreach() argument must be of type array|object, null given" error.
     */
    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    // app/Models/Restaurant.php
public function staff(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(Staff::class);
}
}