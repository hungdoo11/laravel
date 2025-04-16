@extends('layout.adm')

@section('content')
<div class="container mt-4">
    <h2>Quản lý đơn hàng</h2>
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (isset($ordersByStatus))
    <!-- Tabs -->
    <ul class="custom-tabs">
        @foreach(['moi' => 'Mới', 'dang_giao' => 'Đang giao', 'da_giao' => 'Đã giao', 'da_huy' => 'Đã hủy'] as $key => $label)
        <li class="nav-item">
            <a class="nav-link @if ($loop->first) active @endif" data-tab="{{ $key }}" href="javascript:void(0)">{{ $label }}</a>
        </li>
        @endforeach
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3">
        @foreach(['moi', 'dang_giao', 'da_giao', 'da_huy'] as $key)
        <div class="tab-pane @if ($loop->first) active @endif" id="{{ $key }}">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Điện thoại</th>
                        <th>Thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thay đổi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordersByStatus[$key] as $order)
                    <tr>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->phone_number }}</td>
                        <td>{{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}</td>
                        <td>{{ number_format($order->total_price) }} đ</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                        <td>
                            <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="moi" @selected($order->status == 'moi')>Mới</option>
                                    <option value="dang_giao" @selected($order->status == 'dang_giao')>Đang giao</option>
                                    <option value="da_giao" @selected($order->status == 'da_giao')>Đã giao</option>
                                    <option value="da_huy" @selected($order->status == 'da_huy')>Đã hủy</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Không có đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-center">Không có dữ liệu để hiển thị.</p>
    @endif
</div>

<style>
    .custom-tabs {
        display: flex;
        list-style: none;
        padding: 0;
        border-bottom: 1px solid #ddd;
    }

    .custom-tabs .nav-item {
        margin-bottom: -1px;
    }

    .custom-tabs .nav-link {
        cursor: pointer;
        padding: 10px 20px;
        border: 1px solid #ddd;
        border-bottom: none;
        margin-right: 2px;
        background: #f8f9fa;
    }

    .custom-tabs .nav-link.active {
        background: #fff;
        border-bottom: 1px solid #fff;
    }

    .tab-pane {
        display: none;
        border: 1px solid #ddd;
        padding: 15px;
    }

    .tab-pane.active {
        display: block;
    }
</style>

<script>
    document.querySelectorAll('.custom-tabs .nav-link').forEach(tab => {
        tab.addEventListener('click', function() {
            // Xóa class active khỏi tất cả các tab và nội dung
            document.querySelectorAll('.custom-tabs .nav-link').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

            // Thêm class active cho tab được click và nội dung tương ứng
            this.classList.add('active');
            document.querySelector('#' + this.getAttribute('data-tab')).classList.add('active');
        });
    });
</script>
@endsection