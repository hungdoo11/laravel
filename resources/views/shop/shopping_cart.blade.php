@extends('layout.app')

@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h6 class="inner-title">Shopping Cart</h6>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb font-large">
				<a href="{{ route('banhang.index') }}">Home</a> / <span>Shopping Cart</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="container">
	<div id="content">
		@if(Session::has('success'))
		<div class="alert alert-success">{{ Session('success') }}</div>
		@endif

		<div class="table-responsive">
			<!-- Shop Products Table -->
			<table class="shop_table beta-shopping-cart-table" cellspacing="0">
				<thead>
					<tr>
						<th class="product-name">Product</th>
						<th class="product-price">Price</th>
						<th class="product-status">Status</th>
						<th class="product-quantity">Qty.</th>
						<th class="product-subtotal">Total</th>
						<th class="product-remove">Remove</th>
					</tr>
				</thead>
				<tbody>
					@if(Session::has('cart') && !empty(Session('cart')->items))
					@foreach(Session('cart')->items as $id => $item)
					<tr class="cart_item">
						<td class="product-name">
							<div class="media">
								<img class="pull-left" src="{{ asset('images/product/' . $item['item']->image) }}" alt="{{ $item['item']->name }}" width="50">
								<div class="media-body">
									<p class="font-large table-title">{{ $item['item']->name }}</p>
									<!-- Tạm thời bỏ qua Color và Size vì dữ liệu sản phẩm chưa có -->
									<a class="table-edit" href="{{ route('banhang.chitiet', $id) }}">Edit</a>
								</div>
							</div>
						</td>

						<td class="product-price">
							<span class="amount">
								{{ number_format($item['item']->promotion_price == 0 ? $item['item']->unit_price : $item['item']->promotion_price) }} VND
							</span>
						</td>

						<td class="product-status">
							In Stock
						</td>

						<td class="product-quantity">
							<a href="{{ route('banhang.reduceByOne', $id) }}" class="btn btn-warning btn-sm">
								<i class="fa fa-minus"></i>
							</a>
							<span class="qty">{{ $item['qty'] }}</span>
							<a href="{{ route('banhang.increaseByOne', $id) }}" class="btn btn-success btn-sm">
								<i class="fa fa-plus"></i>
							</a>
						</td>

						<td class="product-subtotal">
							<span class="amount">{{ number_format($item['price']) }} VND</span>
						</td>

						<td class="product-remove">
							<a href="{{ route('banhang.removeItem', $id) }}" class="remove" title="Remove this item">
								<i class="fa fa-trash-o"></i>
							</a>
						</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="6" class="text-center">Giỏ hàng của bạn đang trống.</td>
					</tr>
					@endif
				</tbody>

				<tfoot>
					<tr>
						<td colspan="6" class="actions">
							<div class="coupon">
								<label for="coupon_code">Coupon</label>
								<input type="text" name="coupon_code" value="" placeholder="Coupon code">
								<button type="submit" class="beta-btn primary" name="apply_coupon">Apply Coupon <i class="fa fa-chevron-right"></i></button>
							</div>

							<button type="submit" class="beta-btn primary" name="update_cart">Update Cart <i class="fa fa-chevron-right"></i></button>
							<a href="{{ url('/checkout') }}" class="beta-btn primary">Proceed to Checkout <i class="fa fa-chevron-right"></i></a>
						</td>
					</tr>
				</tfoot>
			</table>
			<!-- End of Shop Table Products -->
		</div>

		<!-- Cart Collaterals -->
		<div class="cart-collaterals">
			<form class="shipping_calculator pull-left" action="#" method="post">
				<h2><a href="#" class="shipping-calculator-button">Calculate Shipping <span>↓</span></a></h2>
				<section class="shipping-calculator-form" style="display: none;">
					<p class="form-row form-row-wide">
						<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" style="padding:10px;" rel="calc_shipping_state">
							<option value="">Select a country…</option>
							<!-- Giữ nguyên danh sách quốc gia -->
							<option value="VN">Vietnam</option>
							<!-- Có thể rút gọn danh sách nếu không cần -->
						</select>
					</p>
					<p class="form-row form-row-wide">
						<input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="State / county">
					</p>
					<p class="form-row form-row-wide">
						<input type="text" class="input-text" value="" placeholder="Postcode / Zip" name="calc_shipping_postcode" id="calc_shipping_postcode">
					</p>
					<p><button type="submit" name="calc_shipping" value="1" class="beta-btn primary pull-right">Update Totals</button></p>
				</section>
			</form>

			<div class="cart-totals pull-right">
				<div class="cart-totals-row">
					<h5 class="cart-total-title">Cart Totals</h5>
				</div>
				<div class="cart-totals-row">
					<span>Cart Subtotal:</span>
					<span>{{ Session::has('cart') ? number_format(Session('cart')->totalPrice) : '0' }} VND</span>
				</div>
				<div class="cart-totals-row">
					<span>Shipping:</span>
					<span>Free Shipping</span>
				</div>
				<div class="cart-totals-row">
					<span>Order Total:</span>
					<span>{{ Session::has('cart') ? number_format(Session('cart')->totalPrice) : '0' }} VND</span>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>
		<!-- End of Cart Collaterals -->
		<div class="clearfix"></div>
	</div> <!-- #content -->
</div> <!-- .container -->
@endsection