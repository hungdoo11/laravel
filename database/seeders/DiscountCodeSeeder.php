<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscountCode;

class DiscountCodeSeeder extends Seeder
{
    public function run()
    {
        DiscountCode::create([
            'code' => 'GIAM50K',
            'discount_amount' => 50000,
            'min_order_amount' => 200000,
            'expires_at' => now()->addMonth(),
            'is_active' => true,
        ]);

        DiscountCode::create([
            'code' => 'GIAM20K',
            'discount_amount' => 20000,
            'min_order_amount' => 100000,
            'expires_at' => now()->addDays(15),
            'is_active' => true,
        ]);
    }
}
