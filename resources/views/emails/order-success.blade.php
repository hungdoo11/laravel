<h2>Xin chào {{ $order->customer_name }},</h2>
<p>Cảm ơn bạn đã đặt hàng tại Shop Bánh!</p>
<p>Mã đơn hàng: <strong>#{{ $order->id }}</strong></p>
<p>Địa chỉ: {{ $order->address }}</p>
<p>Hình thức thanh toán: {{ $order->payment_method }}</p>

<h3>Chi tiết đơn hàng:</h3>
<ul>
    @foreach ($order->orderDetails as $detail)
    <li>
        {{ $detail->product->name }} - SL: {{ $detail->quantity }} - Giá: {{ number_format($detail->price) }}đ
    </li>
    @endforeach
</ul>

<p><strong>Tổng tiền: {{ number_format($order->total_price) }}đ</strong></p>
<p>Chúng tôi sẽ sớm giao hàng cho bạn.</p>