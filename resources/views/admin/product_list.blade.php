@extends('layout.adm')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product
                <small>List</small>
            </h1>
        </div>
        <!-- /.col-lg-12 -->
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <tr align="center">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($products) && count($products) > 0)
                @foreach($products as $product)
                <tr class="{{ $loop->odd ? 'odd' : 'even' }} gradeX" align="center">
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if($product->promotion_price && $product->promotion_price != 0)
                        <span style="text-decoration: line-through;">{{ number_format($product->unit_price) }} VNĐ</span>
                        <br>
                        <span>{{ number_format($product->promotion_price) }} VNĐ</span>
                        @else
                        {{ number_format($product->unit_price) }} VNĐ
                        @endif
                    </td>
                    <td>
                        {{ $product->created_at->diffForHumans() }}
                    </td>
                    <td>
                        @if($product->status == 1)
                        Hiện
                        @else
                        Ẩn
                        @endif
                    </td>
                    <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ route('admin.product.delete', $product->id) }}"> Delete</a></td>
                    <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ route('admin.product.edit', $product->id) }}"> Edit</a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="7" align="center">Không có sản phẩm nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection