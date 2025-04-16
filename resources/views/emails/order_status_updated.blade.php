<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật trạng thái đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .content {
            padding: 20px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            border-top: 1px solid #ddd;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Cập nhật trạng thái đơn hàng</h2>
        </div>
        <div class="content">
            <p>Xin chào {{ $order->customer_name }},</p>
            <p>Chúng tôi xin thông báo rằng trạng thái đơn hàng của bạn đã được cập nhật.</p>
            <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
            <p><strong>Trạng thái mới:</strong> {{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }} đ</p>
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email: <a href="mailto:support@banhngon.com">support@banhngon.com</a>.</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Bánh Ngon. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>