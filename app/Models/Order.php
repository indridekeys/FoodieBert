<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function agent() {
    return $this->belongsTo(User::class, 'agent_id');
}

// Used for the {{ $order->restaurant->name }} in your table
public function restaurant() {
    return $this->belongsTo(Restaurant::class);
}
}
