<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu theo trạng thái
        $ordersByStatus = [
            'moi' => Order::where('status', 'moi')->get(),
            'dang_giao' => Order::where('status', 'dang_giao')->get(),
            'da_giao' => Order::where('status', 'da_giao')->get(),
            'da_huy' => Order::where('status', 'da_huy')->get(),
        ];

        // Debug để kiểm tra dữ liệu
        \Log::info('Đơn hàng theo trạng thái:', $ordersByStatus);

        return view('admin.orders.index', compact('ordersByStatus'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:moi,dang_giao,da_giao,da_huy',
        ]);

        // Cập nhật trạng thái
        $order->status = $request->status;
        $order->save();

        // Gửi email thông báo cho khách hàng (đồng bộ)
        try {
            \Mail::to($order->email)->send(new \App\Mail\OrderStatusUpdated($order));
            \Log::info('Đã gửi email cập nhật trạng thái đơn hàng cho: ' . $order->email);
        } catch (\Exception $e) {
            \Log::error('Lỗi gửi email cập nhật trạng thái: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Cập nhật trạng thái thành công nhưng không thể gửi email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    public function details(Order $order)
    {
        return view('admin.orders.details', compact('order'));
    }
}
