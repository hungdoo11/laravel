<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Thêm danh mục cấp 1
        $category1 = Category::create([
            'name' => 'Tin Tức',
            'parent_id' => null,
            'status' => 1,
        ]);

        $category2 = Category::create([
            'name' => 'Thể Thao',
            'parent_id' => null,
            'status' => 0,
        ]);

        // Thêm danh mục cấp 2
        Category::create([
            'name' => 'Bóng Đá',
            'parent_id' => $category2->id,
            'status' => 0,
        ]);

        Category::create([
            'name' => 'Bóng Rổ',
            'parent_id' => $category2->id,
            'status' => 1,
        ]);
    }
}
