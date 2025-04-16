<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng của người dùng hiện tại
        $orders = Order::where('email', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Đảm bảo người dùng chỉ xem được đơn hàng của họ
        if ($order->email !== Auth::user()->email) {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        return view('user.orders.show', compact('order'));
    }
}
