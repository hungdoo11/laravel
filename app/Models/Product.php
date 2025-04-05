<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; // Ensure this matches your database table name

    protected $fillable = [
        'name',
        'unit_price',
        'promotion_price',
        'image',
        'created_at',
        'updated_at',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
