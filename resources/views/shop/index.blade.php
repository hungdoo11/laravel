@extends ('layout.app')

@section('content')
<div class="container">
    <div id="content" class="space-top-none">
        <div class="main-content">
            <div class="space60">&nbsp;</div>
            <div class="row">
                <div class="col-sm-12">
                    <!-- Hiển thị thông báo kết quả tìm kiếm -->
                    @if($search)
                    <div class="alert alert-info">
                        Kết quả tìm kiếm cho từ khóa: <strong>{{ $search }}</strong>
                    </div>
                    @endif

                    <!-- New Products -->
                    <div class="beta-products-list">
                        <h4>New Products</h4>
                        <div class="beta-products-details">
                            @if(isset($new_products) && count($new_products) > 0)
                            <p class="pull-left">{{ count($new_products) }} sản phẩm được tìm thấy</p>
                            @else
                            <p class="pull-left">Không có sản phẩm mới</p>
                            @endif
                            <div class="clearfix"></div>
                        </div>

                        <div class="row">
                            @php $stt = 0; @endphp
                            @if(isset($new_products) && count($new_products) > 0)
                            @foreach($new_products as $new_product)
                            @php $stt++; @endphp
                            <div class="col-sm-3">
                                <div class="single-item">
                                    @if($new_product->promotion_price != 0)
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon sale">Sale</div>
                                    </div>
                                    @endif
                                    <div class="single-item-header">
                                        <a href="{{ route('banhang.chitiet', $new_product->id) }}">
                                            <img src="/images/product/{{ $new_product->image }}" alt="{{ $new_product->name }}" height="250px">
                                        </a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{ $new_product->name }}</p>
                                        <p class="single-item-price">
                                            @if($new_product->promotion_price == 0)
                                            <span class="flash-sale">{{ number_format($new_product->unit_price) }} VND</span>
                                            @else
                                            <span class="flash-del">{{ number_format($new_product->unit_price) }} VND</span>
                                            <span class="flash-sale">{{ number_format($new_product->promotion_price) }} VND</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href="{{ route('banhang.addtocart', $new_product->id) }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="beta-btn primary" href="{{ route('banhang.chitiet', $new_product->id) }}">
                                            Chi tiết <i class="fa fa-chevron-right"></i>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @if($stt % 4 == 0)
                            <div class="space40">&nbsp;</div>
                            @endif
                            @endforeach
                            @else
                            <p>Không có sản phẩm mới.</p>
                            @endif
                        </div>
                    </div> <!-- .beta-products-list -->

                    <!-- Top Products -->
                    <div class="beta-products-list">
                        <h4>Top Products</h4>
                        <div class="beta-products-details">
                            @if(isset($top_products) && count($top_products) > 0)
                            <p class="pull-left">{{ count($top_products) }} sản phẩm được tìm thấy</p>
                            @else
                            <p class="pull-left">Không có sản phẩm nào.</p>
                            @endif
                            <div class="clearfix"></div>
                        </div>

                        <div class="row">
                            @php $stt = 0; @endphp
                            @if(isset($top_products) && count($top_products) > 0)
                            @foreach($top_products as $top_product)
                            @php $stt++; @endphp
                            <div class="col-sm-3">
                                <div class="single-item">
                                    @if($top_product->promotion_price != 0)
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon sale">Sale</div>
                                    </div>
                                    @endif
                                    <div class="single-item-header">
                                        <a href="{{ route('banhang.chitiet', $top_product->id) }}">
                                            <img src="/images/product/{{ $top_product->image }}" alt="{{ $top_product->name }}" height="250px">
                                        </a>
                                    </div>
                                    <div class="single-item-body">
                                        <p class="single-item-title">{{ $top_product->name }}</p>
                                        <p class="single-item-price" style="font-size: 15px; font-weight: bold;">
                                            @if($top_product->promotion_price == 0)
                                            <span class="flash-sale">{{ number_format($top_product->unit_price) }} đồng</span>
                                            @else
                                            <span class="flash-del">{{ number_format($top_product->unit_price) }} đồng</span>
                                            <span class="flash-sale">{{ number_format($top_product->promotion_price) }} đồng</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="single-item-caption">
                                        <a class="add-to-cart pull-left" href="{{ route('banhang.addtocart', $top_product->id) }}">
                                            <i class="fa fa-shopping-cart"></i>
                                        </a>
                                        <a class="beta-btn primary" href="{{ route('banhang.chitiet', $top_product->id) }}">
                                            Chi tiết <i class="fa fa-chevron-right"></i>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            @if($stt % 4 == 0)
                            <div class="space40">&nbsp;</div>
                            @endif
                            @endforeach
                            @else
                            <p>Không có sản phẩm nào.</p>
                            @endif
                        </div>
                    </div> <!-- .beta-products-list -->
                </div> <!-- end section with sidebar and main content -->
            </div> <!-- .main-content -->
        </div> <!-- #content -->
    </div> <!-- .container -->
    @endsection