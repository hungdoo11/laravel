<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'id_bill');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    protected $table = 'bill_details'; // Đảm bảo tên bảng khớp
    protected $fillable = ['id_bill', 'id_product', 'quantity', 'unit_price'];
}
