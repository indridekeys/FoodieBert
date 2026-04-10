<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'restaurant_id',
    'food_name',
    'price',
    'quantity',
    'delivery_address',
    'status',
    'agent_id',
];

    /**
     * The attributes that should be cast.
     * This automatically handles the array-to-string conversion.
     */
    protected $casts = [
        'food_names' => 'array',
        'prices'     => 'array',
        'quantities' => 'array',
    ];

    // Relationship: The Customer who placed the order
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: The Restaurant fulfilling the order
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    // Relationship: The Delivery Agent (User) assigned to the order
    public function delivery_agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}