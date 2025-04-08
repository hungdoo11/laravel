<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // Mảng chứa các giá trị mẫu để tạo ngẫu nhiên
        $cakeTypes = ['Bánh Ngọt', 'Bánh Kem', 'Bánh Bông Lan', 'Bánh Mousse', 'Bánh Tiramisu', 'Bánh Donut', 'Bánh Macaron', 'Bánh Cheesecake'];
        $flavors = ['Sầu riêng', 'Chocolate', 'Dâu Tây', 'Trà Xanh', 'Chanh Dây', 'Hạt Dẻ', 'Cam', 'Phủ Đường', 'Trứng Muối', 'Vani'];
        $descriptions = ['thơm ngon', 'mềm mịn', 'béo ngậy', 'thanh mát', 'chua ngọt', 'ngọt ngào', 'tươi mới'];
        $units = ['cái', 'hộp'];

        // Lấy danh sách file hình ảnh có sẵn trong thư mục public/images/product/
        $images = glob(public_path('images/product/*.jpg'));
        $images = array_map('basename', $images); // Chỉ lấy tên file (bỏ đường dẫn)

        // Tạo 30 sản phẩm (hoặc 1000 nếu bạn muốn)
        for ($i = 0; $i < 30; $i++) {
            $cakeType = $cakeTypes[array_rand($cakeTypes)];
            $flavor = $flavors[array_rand($flavors)];
            $description = $descriptions[array_rand($descriptions)];
            $unit = $units[array_rand($units)];
            $id_type = rand(3, 7);
            $unit_price = rand(50000, 300000);
            $promotion_price = $unit_price - rand(10000, 30000);
            $new = rand(0, 1);
            $top = rand(0, 1);

            $name = "$cakeType $flavor";
            $description = "$cakeType $flavor $description";
            $image = $images[array_rand($images)]; // Chọn ngẫu nhiên một file hình ảnh có sẵn

            Product::create([
                'name' => $name,
                'id_type' => $id_type,
                'description' => $description,
                'unit_price' => $unit_price,
                'promotion_price' => $promotion_price,
                'image' => $image,
                'unit' => $unit,
                'new' => $new,
                'top' => $top,
            ]);
        }
    }
}
