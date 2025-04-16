@extends('layout.app')

@section('content')
<div class="container">
    <h2>Sản phẩm yêu thích</h2>
    <div class="row">
        @foreach($favoriteProducts as $product)
        <div class="col-sm-3">
            <div class="single-item" style="padding: 3px 0px; margin: 12px 0px;">
                @if($product->promotion_price != 0)
                <div class="ribbon-wrapper">
                    <div class="ribbon sale">Sale</div>
                </div>
                @endif
                <div class="single-item-header">
                    <a href="{{ route('banhang.chitiet', $product->id) }}">
                        <img src="/images/product/{{ $product->image }}" alt="{{ $product->name }}" height="250px">
                    </a>
                </div>
                <div class="single-item-body">
                    <p class="single-item-title">{{ $product->name }}</p>
                    <p class="single-item-price">
                        @if($product->promotion_price == 0)
                        <span class="flash-sale">{{ number_format($product->unit_price) }} VND</span>
                        @else
                        <span class="flash-del">{{ number_format($product->unit_price) }} VND</span>
                        <span class="flash-sale">{{ number_format($product->promotion_price) }} VND</span>
                        @endif
                    </p>
                </div>
                <div class="single-item-caption">
                    <!-- Thêm vào giỏ hàng -->
                    <a class="add-to-cart pull-left" href="{{ route('banhang.addtocart', $product->id) }}">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                    <a class="beta-btn primary" href="{{ route('banhang.chitiet', $product->id) }}">
                        Chi tiết <i class="fa fa-chevron-right"></i>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection