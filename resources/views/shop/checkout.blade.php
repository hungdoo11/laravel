@extends('layout.app')
@section('content')
<div class="container">
	<div id="content">
		@if (session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
		@endif
		@if (session('error'))
		<div class="alert alert-danger">{{ session('error') }}</div>
		@endif

		<form action="{{ url('checkout') }}" method="post" class="beta-form-checkout">
			@csrf
			<div class="row checkout">
				<div class="col-sm-6">
					<h4>Đặt hàng</h4>
					<div class="space20">&nbsp;</div>
					<div class="form-block">
						<label for="name">Họ tên*</label>
						<input type="text" id="name" name="name" placeholder="Họ tên" required>
					</div>
					<div class="form-block">
						<label>Giới tính</label>
						<input id="gender" type="radio" name="gender" value="nam" checked style="width: 10%">
						<span style="margin-right: 10%">Nam</span>
						<input id="gender" type="radio" name="gender" value="nu" style="width: 10%">
						<span>Nữ</span>
					</div>
					<div class="form-block">
						<label for="email">Email*</label>
						<input type="email" id="email" name="email" placeholder="example@gmail.com" required>
					</div>
					<div class="form-block">
						<label for="address">Địa chỉ*</label>
						<input type="text" id="address" name="address" placeholder="Street Address" required>
					</div>
					<div class="form-block">
						<label for="phone_number">Điện thoại*</label>
						<input type="text" id="phone_number" name="phone_number" required>
					</div>
					<div class="form-block">
						<label for="notes">Ghi chú</label>
						<textarea id="notes" name="notes"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Đặt hàng</button>
				</div>
				<div class="col-sm-6">
					<div class="your-order">
						<div class="your-order-head">
							<h5>Đơn hàng của bạn</h5>
						</div>
						<div class="your-order-body" style="padding: 0px 10px">
							<div class="your-order-item">
								@if(isset($productCarts) && !empty($productCarts))
								@foreach($productCarts as $product)
								<div class="media">
									<img width="25%" src="{{ asset('images/product/' . $product['item']['image']) }}" alt="{{ $product['item']['name'] }}" class="pull-left">
									<div class="media-body">
										<p class="font-large">{{ $product['item']['name'] }}</p>
										<span class="cart-item-amount">{{ $product['qty'] }} *
											@if($product['item']['promotion_price'] == 0)
											{{ number_format($product['item']['unit_price']) }}
											@else
											{{ number_format($product['item']['promotion_price']) }}
											@endif
										</span>
										@php
										$dongia = $product['item']['promotion_price'] == 0 ? $product['item']['unit_price'] : $product['item']['promotion_price'];
										$thanhtien = $dongia * $product['qty'];
										@endphp
										<span class="color-gray your-order-info">Số lượng: {{ $product['qty'] }}</span>
										<span class="color-gray your-order-info">Thành tiền: {{ number_format($thanhtien) }} đồng</span>
									</div>
								</div>
								@endforeach
								@else
								<p>Giỏ hàng trống</p>
								@endif
							</div>
							<div class="your-order-item">
								<div class="pull-left">
									<p class="your-order-f18">Tổng tiền:</p>
								</div>
								<div class="pull-right">
									<h5 class="color-black">{{ isset($cart) ? number_format($cart->totalPrice) : 0 }}</h5>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="your-order-head">
							<h5>Hình thức thanh toán</h5>
						</div>
						<div class="form-block">
							<label for="payment_method">Hình thức thanh toán*</label>
							<select name="payment_method" id="payment_method" required>
								<option value="cod">Thanh toán khi nhận hàng (COD)</option>
								<option value="bank_transfer">Chuyển khoản ngân hàng</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection