<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = [
        'code',
        'discount_amount',
        'min_order_amount',
        'expires_at',
        'is_active',
    ];

    protected $dates = ['expires_at'];
}
