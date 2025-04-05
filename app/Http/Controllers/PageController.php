<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use App\Models\Slide;
use App\Models\Customer;
use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Support\Facades\Auth;



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

        // Trả về view với dữ liệu
        return view('shop.index', compact('slides', 'new_products', 'top_products', 'promotion_products', 'search'));
    }
    public function getChiTiet($sanpham_id)
    {
        $sanpham = Product::find($sanpham_id);
        return view('chitiet', compact('sanpham'));
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
        $cart = Session::get('cart');
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->gender = $request->input('gender');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->phone_number = $request->input('phone_number');
        $customer->note = $request->input('notes');
        $customer->save();

        $bill = new Bill();
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = $cart->totalPrice;
        $bill->payment = $request->input('payment_method');
        $bill->note = $request->input('notes');
        $bill->save();

        foreach ($cart->items as $key => $value) {
            $bill_detail = new BillDetail();
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = $value['price'] / $value['qty'];
            $bill_detail->save();
        }
        Session::forget('cart');
        return redirect()->back()->with('success', 'Đặt hàng thành công');
    }
    public function getSignin()
    {

        return view('shop.signup');
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
}
