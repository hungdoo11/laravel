<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Message;

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

    public function index()
    {
        $users = User::whereHas('messages', function ($q) {
            $q->where('from_user_id', auth()->id())
                ->orWhere('to_user_id', auth()->id());
        })->get();

        return view('admin.chat.index', compact('users'));
    }

    // Hiển thị tin nhắn cụ thể và form trả lời
    // public function show($id)
    // {
    //     // Thay vì sử dụng sender_id và receiver_id, bạn dùng from_user_id và to_user_id
    //     $messages = Message::with('sender')
    //         ->where('to_user_id', auth()->id()) // chỉ lấy tin nhắn gửi đến admin
    //         ->groupBy('from_user_id')
    //         ->selectRaw('MAX(id) as id, from_user_id')
    //         ->get();


    //     // Nếu không có tin nhắn, bạn có thể trả về một trang thông báo hoặc thông báo trong view.
    //     if ($messages->isEmpty()) {
    //         return redirect()->route('admin.chat.index')->with('error', 'Không có tin nhắn nào!');
    //     }

    //     return view('admin.chat.show', compact('messages'));
    // }

    public function show($id)
    {
        $adminId = auth()->id();
        $messages = Message::where(function ($query) use ($id) {
            $query->where('from_user_id', $id)
                ->orWhere('to_user_id', $id);
        })->orderBy('created_at')->get();

        $user = User::find($id); // lấy thông tin người dùng đang chat
        return view('admin.chat.show', compact('messages', 'user', 'adminId'));
    }




    // Trả lời tin nhắn
    public function reply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = new Message();
        $message->from_user_id = auth()->id(); // Admin gửi
        $message->to_user_id = $id;            // Người nhận là user
        $message->message = $request->message;
        $message->save();

        return redirect()->route('admin.chat.show', $id)->with('success', 'Tin nhắn đã được gửi!');
    }
}
