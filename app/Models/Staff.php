<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    // app/Models/Staff.php
protected $fillable = ['restaurant_id', 'name', 'position', 'photo'];

public function restaurant() {
    return $this->belongsTo(Restaurant::class);
}
}
