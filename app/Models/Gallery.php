<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['restaurant_id', 'path', 'caption'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}

