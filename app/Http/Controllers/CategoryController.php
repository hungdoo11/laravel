<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;

class CategoryController extends Controller
{
    public function showByType($id)
    {
        $type = ProductType::findOrFail($id); // Tìm loại sản phẩm
        $products = Product::where('id_type', $id)->get(); // Lấy các sản phẩm thuộc loại này

        return view('product.by_type', compact('type', 'products'));
    }

    public function index(Request $request)
    {
        // Lấy giá trị status từ request (nếu có)
        $status = $request->query('status');

        // Query để lấy danh sách danh mục
        $query = Category::query();

        // Nếu có status được chọn, thêm điều kiện lọc
        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // Lấy danh sách danh mục (có thể phân trang nếu cần)
        $categories = $query->get();

        // Trả về view với danh sách danh mục và giá trị status hiện tại
        return view('admin.cate', compact('categories', 'status'));
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.cate')->with('success', 'Xóa danh mục thành công');
    }

    public function edit($id)
    {
        // Logic để hiển thị form chỉnh sửa (có thể thêm sau)
        return view('admin.cate', compact('id'));
    }
}
