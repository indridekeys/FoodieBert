<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Including user_id and restaurant_id to prevent 'Not Null' or 'Mass Assignment' errors.
     */
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'date',
        'time',
        'guests',
        'status',
    ];

    /**
     * Get the user that made the booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the restaurant that owns the booking.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}