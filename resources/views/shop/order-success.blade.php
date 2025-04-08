@extends('layout.app')

@section('content')
<div class="container">
    <div id="content">
        <div class="order-success text-center">
            <h4>Đặt hàng thành công!</h4>
            <p>Đơn hàng đã được đặt thành công và sẽ giao đến trong vòng 4-7 ngày.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">Quay lại trang chủ</a>
        </div>
    </div>
</div>

<style>
    .order-success {
        padding: 50px 0;
    }

    .order-success h4 {
        color: #28a745;
        /* Màu xanh lá để báo thành công */
        font-size: 24px;
        margin-bottom: 20px;
    }

    .order-success p {
        font-size: 16px;
        margin-bottom: 30px;
    }

    .text-center {
        text-align: center;
    }
</style>
@endsection