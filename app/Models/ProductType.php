<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $table = 'product_types'; // Tên bảng nếu không theo chuẩn Laravel

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    // Nếu muốn lấy danh sách sản phẩm liên quan
    public function products()
    {
        return $this->hasMany(Product::class, 'id_type');
    }
}
