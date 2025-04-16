<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DiscountCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        $cart = Session::get('cart', []);
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('shop.checkout', compact('cart', 'total'));
    }

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string',
        ]);

        $code = DiscountCode::where('code', $request->discount_code)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->first();

        if (!$code) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }

        $cart = Session::get('cart', []);
        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        if ($code->min_order_amount && $total < $code->min_order_amount) {
            return redirect()->back()->with('error', 'Đơn hàng của bạn chưa đạt giá trị tối thiểu ' . number_format($code->min_order_amount) . ' đ để áp dụng mã này.');
        }

        Session::put('discount', [
            'code' => $code->code,
            'discount_amount' => $code->discount_amount,
        ]);

        return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,transfer',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.checkout')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        $discount = Session::get('discount');
        $discountAmount = $discount ? $discount['discount_amount'] : 0;
        $finalTotal = max(0, $total - $discountAmount);

        $order = Order::create([
            'customer_name' => $request->customer_name,
            'email' => Auth::user()->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'total_price' => $finalTotal,
            'status' => 'moi',
        ]);

        // Xóa giỏ hàng và mã giảm giá sau khi đặt hàng
        Session::forget('cart');
        Session::forget('discount');

        return redirect()->route('user.orders.index')->with('success', 'Đặt hàng thành công!');
    }
}
