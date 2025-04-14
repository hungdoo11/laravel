@extends ('layout.app')

@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h6 class="inner-title">Product</h6>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb font-large">
				<a href="{{ url('/') }}">Home</a> / <span>Product</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="container">
	<div id="content">
		<div class="row">
			<div class="col-sm-9">
				<div class="row">
					<div class="col-sm-4">
						<img src="{{ asset('assets/dest/images/products/6.jpg') }}" alt="">
					</div>
					<div class="col-sm-8">
						<div class="single-item-body">
							<p class="single-item-title">Sample Woman Top</p>
							<p class="single-item-price">
								<span>$34.55</span>
							</p>
						</div>

						<div class="clearfix"></div>
						<div class="space20">&nbsp;</div>

						<div class="single-item-desc">
							<p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo ms id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus...</p>
						</div>
						<div class="space20">&nbsp;</div>

						<p>Options:</p>
						<div class="single-item-options">
							<select class="wc-select" name="size">
								<option>Size</option>
								<option value="XS">XS</option>
								<option value="S">S</option>
								<option value="M">M</option>
								<option value="L">L</option>
								<option value="XL">XL</option>
							</select>
							<select class="wc-select" name="color">
								<option>Color</option>
								<option value="Red">Red</option>
								<option value="Green">Green</option>
								<option value="Yellow">Yellow</option>
								<option value="Black">Black</option>
								<option value="White">White</option>
							</select>
							<select class="wc-select" name="qty">
								<option>Qty</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
							<a class="add-to-cart" href="#"><i class="fa fa-shopping-cart"></i></a>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>

				<div class="space40">&nbsp;</div>
				<div class="woocommerce-tabs">
					<ul class="tabs">
						<li><a href="#tab-description">Description</a></li>
						<li><a href="#tab-reviews">Reviews (0)</a></li>
					</ul>

					<div class="panel" id="tab-description">
						<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit...</p>
					</div>
					<div class="panel" id="tab-reviews">
						<p>No Reviews</p>
					</div>
				</div>

				<div class="space50">&nbsp;</div>
				<div class="beta-products-list">
					<h4>Related Products</h4>

					<div class="row">
						@foreach([4, 5, 6] as $img)
						<div class="col-sm-4">
							<div class="single-item">
								@if($img == 6)
								<div class="ribbon-wrapper">
									<div class="ribbon sale">Sale</div>
								</div>
								@endif
								<div class="single-item-header">
									<a href="{{ url('/product') }}">
										<img src="{{ asset('assets/dest/images/products/'.$img.'.jpg') }}" alt="">
									</a>
								</div>
								<div class="single-item-body">
									<p class="single-item-title">Sample Woman Top</p>
									<p class="single-item-price">
										@if($img == 6)
										<span class="flash-del">$34.55</span>
										<span class="flash-sale">$33.55</span>
										@else
										<span>$34.55</span>
										@endif
									</p>
								</div>
								<div class="single-item-caption">
									<a class="add-to-cart pull-left" href="#"><i class="fa fa-shopping-cart"></i></a>
									<a class="beta-btn primary" href="#">Details <i class="fa fa-chevron-right"></i></a>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>

			<div class="col-sm-3 aside">
				<div class="widget">
					<h3 class="widget-title">Best Sellers</h3>
					<div class="widget-body">
						<div class="beta-sales beta-lists">
							@foreach(range(1,4) as $i)
							<div class="media beta-sales-item">
								<a class="pull-left" href="{{ url('/product') }}">
									<img src="{{ asset('assets/dest/images/products/sales/'.$i.'.png') }}" alt="">
								</a>
								<div class="media-body">
									Sample Woman Top
									<span class="beta-sales-price">$34.55</span>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>

				<div class="widget">
					<h3 class="widget-title">New Products</h3>
					<div class="widget-body">
						<div class="beta-sales beta-lists">
							@foreach(range(1,4) as $i)
							<div class="media beta-sales-item">
								<a class="pull-left" href="{{ url('/product') }}">
									<img src="{{ asset('assets/dest/images/products/sales/'.$i.'.png') }}" alt="">
								</a>
								<div class="media-body">
									Sample Woman Top
									<span class="beta-sales-price">$34.55</span>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection