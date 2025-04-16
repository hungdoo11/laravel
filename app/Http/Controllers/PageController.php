<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Slide;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\BillDetail;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductType;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getIndex(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ query string (name="s" trong form)
        $search = $request->query('s');

        // Lấy danh sách slides
        $slides = Slide::all();

        // Lấy sản phẩm mới
        $new_products = Product::where('new', 1);
        if ($search) {
            $new_products = $new_products->where('name', 'like', '%' . $search . '%');
        }
        $new_products = $new_products->get() ?? collect([]);

        // Lấy sản phẩm nổi bật
        $top_products = Product::where('top', 1);
        if ($search) {
            $top_products = $top_products->where('name', 'like', '%' . $search . '%');
        }
        $top_products = $top_products->get() ?? collect([]);

        // Lấy sản phẩm khuyến mãi
        $promotion_products = Product::where('promotion_price', '<>', 0);
        if ($search) {
            $promotion_products = $promotion_products->where('name', 'like', '%' . $search . '%');
        }
        $promotion_products = $promotion_products->get() ?? collect([]);

        $messages = [];

        if (auth()->check() && auth()->user()->level == 3) {
            $user = auth()->user();
            $messages = Message::where(function ($query) use ($user) {
                $query->where('from_user_id', $user->id)
                    ->orWhere('to_user_id', $user->id);
            })->with('sender')->orderBy('created_at')->get();
            // ->orderBy('created_at', 'asc') // hoặc ->latest('created_at')

        }

        // Trả về view với dữ liệu
        return view('shop.index', compact('slides', 'new_products', 'top_products', 'promotion_products', 'search', 'messages'));
    }
    public function getChiTiet($sanpham_id)
    {
        $sanpham = Product::find($sanpham_id);
        return view('shop.product', compact('sanpham'));
    }
    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
        }

        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $id);
        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }
    public function increaseByOne(Request $request, $id)
    {
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->increaseByOne($id);
        $request->session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã tăng số lượng sản phẩm!');
    }

    public function reduceByOne(Request $request, $id)
    {
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            $request->session()->put('cart', $cart);
        } else {
            $request->session()->forget('cart');
        }
        return redirect()->back()->with('success', 'Đã giảm số lượng sản phẩm!');
    }

    public function removeItem(Request $request, $id)
    {
        $oldCart = Session('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            $request->session()->put('cart', $cart);
        } else {
            $request->session()->forget('cart');
        }
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function getCheckout()
    {
        // Check if the cart session exists
        if (!Session::has('cart')) {
            return redirect()->route('banhang.shopping_cart')->with('error', 'Giỏ hàng của bạn trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
        }

        // Get the cart from the session
        $cart = Session::get('cart');
        // Extract the cart items (assuming 'items' is the property holding the cart products)
        $productCarts = $cart->items ?? [];

        // Pass $cart and $productCarts to the view
        return view('shop.checkout', compact('cart', 'productCarts'));
    }

    public function postCheckout(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:nam,nu',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        // Lấy giỏ hàng từ session
        $cart = session('cart');

        // Kiểm tra giỏ hàng
        if (!$cart || count($cart->items) == 0) {
            return back()->with('error', 'Giỏ hàng trống');
        }

        // Lưu đơn hàng
        $order = new Order();
        $order->customer_name = $request->name;
        $order->gender = $request->gender;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->phone_number = $request->phone_number;
        $order->notes = $request->notes;
        $order->payment_method = $request->payment_method;
        $order->total_price = $cart->totalPrice;
        $order->status = 'moi';
        $order->save();

        // Lưu chi tiết đơn hàng
        foreach ($cart->items as $product_id => $item) {
            $detail = new OrderDetail();
            $detail->order_id = $order->id;
            $detail->product_id = $product_id;
            $detail->quantity = $item['qty'];
            $detail->price = $item['item']['promotion_price'] == 0 ? $item['item']['unit_price'] : $item['item']['promotion_price'];
            $detail->save();
        }

        // Gửi email xác nhận
        try {
            Mail::to($order->email)->send(new OrderSuccessMail($order));
        } catch (\Exception $e) {
            \Log::error('Lỗi gửi email: ' . $e->getMessage());
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->back()->with('success', 'Đặt hàng thành công! Kiểm tra email.');
    }

    public function orderSuccess()
    {
        return view('shop.order-success');
    }
    public function index(Request $request)
    {
        $status = $request->query('status', ''); // Lấy giá trị status từ query string, mặc định là rỗng
        $categories = Category::when($status !== '', function ($query) use ($status) {
            return $query->where('status', $status);
        })->get();
        $categories = Category::all();

        return view('admin.cate', compact('categories', 'status'));
    }

    // Các hàm khác như delete, edit, v.v.

    public function getSignin()
    {

        return view('shop.dangky');
    }



    public function postSignin(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|max:20',
                'fullname' => 'required',
                'phone' => 'required|regex:/^[0-9\+]{10,15}$/',
                'address' => 'required',
                'repassword' => 'required|same:password',
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'email.unique' => 'Email đã có người sử dụng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'repassword.same' => 'Mật khẩu không giống nhau',
                'password.min' => 'Mật khẩu ít nhất 6 ký tự',
                'phone.required' => 'Vui lòng nhập số điện thoại',
                'phone.regex' => 'Số điện thoại không hợp lệ',
                'address.required' => 'Vui lòng nhập địa chỉ',
            ]
        );

        User::create([
            'full_name' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'level' => 3,
        ]);

        return redirect()->back()->with('success', 'Tạo tài khoản thành công');


        // $user = new User();
        // $user->full_name = $request->fullname;
        // $user->email = $request->email;
        // $user->password = Hash::make($request->pass); // Sửa $request->password thành $request->pass
        // $user->phone = $request->phone;
        // $user->address = $request->address;
        // $user->level = 3; // level=1: admin; level=2: kỹ thuật; level=3: khách hàng
        // $user->save();

        // return redirect()->back()->with('success', 'Tạo tài khoản thành công');
    }

    public function getLogin()
    {
        return view('shop.login');
    }

    public function postLogin(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:20'
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Không đúng định dạng email',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu ít nhất 6 ký tự'
            ]
        );

        $credentials = $validated;
        if (Auth::attempt($credentials)) {
            return redirect()->route('shop.index')->with(['flag' => 'success', 'message' => 'Đăng nhập thành công']);
        } else {
            return redirect()->back()->with(['flag' => 'danger', 'message' => 'Đăng nhập không thành công']);
        }
    }
    public function getLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('banhang.index');
    }

    public function getInputEmail()
    {

        return view('emails.input-email');
    }

    public function postInputEmail(Request $req)
    {
        $req->validate([
            'txtEmail' => 'required|email',
        ], [
            'txtEmail.required' => 'Vui lòng nhập email.',
            'txtEmail.email' => 'Email không đúng định dạng.',
        ]);

        $email = $req->txtEmail;
        $user = User::where('email', $email)->first();

        if ($user) {
            // Tạo mật khẩu mới và cập nhật vào cơ sở dữ liệu
            $newPassword = Str::random(8);
            $user->password = bcrypt($newPassword);
            $user->save();

            // Gửi email với mật khẩu mới
            $sentData = [
                'title' => 'Mật khẩu mới của bạn là:',
                'body' => $newPassword
            ];

            try {
                Mail::to($email)->send(new \App\Mail\SendMail($sentData));
                Session::flash('message', 'Send email successfully!');
                return view('shop.login');
            } catch (\Exception $e) {
                return redirect()->route('getInputEmail')->with('message', 'Failed to send email: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('getInputEmail')->with('message', 'Your email is not right');
        }
    }
    // Trong AppServiceProvider hoặc controller base


    // public function boot()
    // {
    //     $loai_sp = ProductType::all();
    //     view()->share('loai_sp', $loai_sp);
    // }



    public function showProductType()
    {

        return view('shop.product_by_type');
    }
    public function showByType($id)
    {
        $products = DB::table('products')->where('id_type', $id)->get();

        return view('shop.product_by_type', compact('products'));
    }

    public function toggleFavorite(Request $request, $productId)
    {
        $favorites = session()->get('favorites', []);

        // Kiểm tra xem sản phẩm đã có trong danh sách yêu thích chưa
        if (in_array($productId, $favorites)) {
            // Nếu có thì xóa khỏi danh sách
            $favorites = array_diff($favorites, [$productId]);
        } else {
            // Nếu chưa có thì thêm vào danh sách
            $favorites[] = $productId;
        }

        // Lưu lại danh sách yêu thích vào session
        session()->put('favorites', $favorites);

        return back(); // Quay lại trang trước
    }

    public function showFavorites()
    {
        $favoriteProductIds = session('favorites', []);
        $favoriteProducts = Product::whereIn('id', $favoriteProductIds)->get();

        return view('shop.favorites', compact('favoriteProducts'));
    }
    public function chatbox()
    {
        $user = auth()->user();
        $messages = [];

        if ($user) {
            $messages = Message::where(function ($query) use ($user) {
                $query->where('from_user_id', $user->id)
                    ->orWhere('to_user_id', $user->id);
            })->orderBy('created_at')->get();
        }

        return view('shop.index', compact('messages'));
    }
}
