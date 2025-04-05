<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Bánh Crepe Sầu riêng',
                'id_type' => 5,
                'description' => 'Bánh crepe sầu riêng thơm ngon',
                'unit_price' => 150000,
                'promotion_price' => 120000,
                'image' => 'pancake-sau-rieng-hop-6.jpg',
                'unit' => 'hộp',
                'new' => 1,
                'top' => 1,
            ],
            [
                'name' => 'Bánh Crepe Chocolate',
                'id_type' => 5,
                'description' => 'Bánh crepe chocolate thơm ngon',
                'unit_price' => 180000,
                'promotion_price' => 160000,
                'image' => 'crepe-chocolate.jpg',
                'unit' => 'hộp',
                'new' => 1,
                'top' => 1,
            ],
            [
                'name' => 'Bánh Crepe Sầu riêng - Chuối',
                'id_type' => 5,
                'description' => 'Bánh crepe sầu riêng và chuối',
                'unit_price' => 150000,
                'promotion_price' => 120000,
                'image' => 'crepe-chuoi.jpg',
                'unit' => 'hộp',
                'new' => 0,
                'top' => 0,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
