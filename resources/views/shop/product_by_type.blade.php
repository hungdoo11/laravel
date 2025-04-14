@extends('layout.app')

@section('content')
<div class="container">
    <h2>Danh sách sản phẩm theo loại</h2>

    @forelse ($products as $product)
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px;">
        <h3>{{ $product->name }}</h3>

        @if ($product->image)
        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" width="150">
        @else
        <img src="{{ asset('images/default-placeholder.png') }}" alt="Hình ảnh mặc định" width="150">
        @endif

        <p>{{ $product->description }}</p>
        <p>Giá: {{ number_format($product->unit_price, 0, ',', '.') }}đ</p>
    </div>
    @empty
    <p>Không có sản phẩm nào để hiển thị.</p>
    @endforelse

</div>
@endsection