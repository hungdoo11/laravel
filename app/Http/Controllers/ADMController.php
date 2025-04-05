<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ADMController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('admin.login');
    }

    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        // Lấy thông tin đăng nhập
        $credentials = $request->only('email', 'password');

        // Kiểm tra đăng nhập với guard 'admin' (nếu bạn dùng multi-auth) hoặc guard mặc định
        if (Auth::attempt($credentials)) {
            // Nếu đăng nhập thành công, kiểm tra quyền admin (ví dụ: level = 1)
            if (Auth::user()->level == 1) { // Giả sử level 1 là admin
                return redirect()->route('admin.cate')->with('success', 'Đăng nhập admin thành công!');
            } else {
                Auth::logout(); // Đăng xuất nếu không phải admin
                return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập khu vực admin!');
            }
        }

        // Nếu đăng nhập thất bại
        return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function showUser()
    {
        $users = User::all(); // Fetch all users
        return view('admin.user_list', compact('users'));
    }


    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.product')->with('success', 'Xóa sản phẩm thành công');
    }

    // Các phương thức khác giữ nguyên
    public function showCate()
    {
        return view('admin.cate_list');
    }

    public function addCate()
    {
        return view('admin.cate_add');
    }

    public function editCate()
    {
        return view('admin.cate_edit');
    }

    public function showProduct()
    {
        $products = Product::all(); // Fetch all products from the database
        return view('admin.product_list', compact('products'));
    }

    public function addProduct()
    {
        return view('admin.product_add');
    }

    public function editProduct()
    {
        return view('admin.product_edit');
    }



    public function addUser()
    {
        return view('admin.user_add');
    }

    public function editUser()
    {
        return view('admin.user_edit');
    }
}
