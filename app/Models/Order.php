<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // ...
    protected $fillable = [
        'customer_name',
        'gender',
        'email',
        'address',
        'phone_number',
        'notes',
        'payment_method',
        'total_price',
        'status'
    ];
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
