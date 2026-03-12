<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToRestaurant
{
    protected static function bootBelongsToRestaurant()
    {
        static::addGlobalScope('restaurant_owner', function (Builder $builder) {
            if (Auth::check() && Auth::user()->role === 'owner') {
                $restaurantIds = Auth::user()->restaurants()->pluck('id');
                $builder->whereIn('restaurant_id', $restaurantIds);
            }
        });
    }
}