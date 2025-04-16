@extends('layout.adm')

@section('content')
<div class="container mt-4">
    <h2>Chi tiết đơn hàng #{{ $order->id }}</h2>
    <p><strong>Khách hàng:</strong> {{ $order->customer_name }}</p>
    <p><strong>Điện thoại:</strong> {{ $order->phone_number }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }} đ</p>
    <p><strong>Trạng thái:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>

    <h4>Danh sách sản phẩm</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->price) }} đ</td>
                <td>{{ number_format($detail->price * $detail->quantity) }} đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection