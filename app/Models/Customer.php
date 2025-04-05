<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers'; // Đảm bảo tên bảng khớp với migration
    protected $fillable = [
        'name',
        'gender',
        'email',
        'address',
        'phone_number',
        'note'
    ];
}
