<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'price',
        'image',       
        'image_url',  
        'is_available'
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * ACCESSOR: Get the full path for the dish image.
     * This ensures {{ $item->dish_image }} always works in your Blade.
     */
    public function getDishImageAttribute()
    {
        if ($this->image) {
            // If the image is a full URL (from a seeder), return it directly
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
            
            // Otherwise, return the path from the storage link
            return asset('storage/' . $this->image);
        }

        // Fallback to a default image if no image is registered
        return asset('uploads/default-dish.jpg');
    }

    /**
     * Get the restaurant that owns the menu item.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}