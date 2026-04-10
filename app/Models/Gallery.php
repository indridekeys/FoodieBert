<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * We add 'name' and 'price' here so they can be saved via the Controller.
     */
    protected $fillable = [
        'restaurant_id', 
        'path', 
        'name',    // NEW: Captures the item title
        'price',   // NEW: Captures the item cost
        'caption'  // Kept for general descriptions
    ];

    /**
     * Relationship: A gallery item belongs to a specific restaurant.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Optional: Helper to format price for Blade views
     * Usage: {{ $photo->formatted_price }}
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
}

