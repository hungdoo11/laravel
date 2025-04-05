<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model

{
    protected $table = 'slide'; // Tên bảng trong database
    protected $fillable = ['image', 'title', 'description']; // Các cột có thể điền
}
