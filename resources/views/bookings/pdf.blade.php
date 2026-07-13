<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Hóa đơn PolyPitch #{{ $booking->id }}</title>
    <style>
        /* Cấu hình font chữ hiển thị tốt tiếng Việt trong DomPDF */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 10px;
        }
        .title {
            text-align: center;
            text-transform: uppercase;
            color: #1e3a8a;
            font-size: 20px;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .info-table, .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .item-table th {
            background-color: #f3f4f6;
            color: #1f2937;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        .item-table td {
            padding: 10px 8px;
            border: 1px solid #e5e7eb;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row {
            font-size: 16px;
            font-weight: bold;
            color: #dc2626;
        }
        .footer-note {
            margin-top: 5px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px dashed #ccc;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td style="font-size: 18px; font-weight: bold; color: #16a34a;">POLYPITCH SYSTEM</td>
                <td style="text-align: right; color: #6b7280;">Mã hóa đơn: #{{ $booking->id }}</td>
            </tr>
        </table>

        <div class="title">HÓA ĐƠN THANH TOÁN</div>

        <table class="info-table">
            <tr>
                <td style="width: 50%;">
                    <strong>Khách hàng:</strong> {{ $booking->user->name }}<br>
                    <strong>Email:</strong> {{ $booking->user->email }}<br>
                    <strong>Số điện thoại:</strong> {{ $booking->user->phone ?? 'Chưa cập nhật' }}
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Sân bóng:</strong> {{ $booking->field->name }}<br>
                    <strong>Ngày đá:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }}<br>
                    <strong>Thời gian:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                </td>
            </tr>
        </table>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Nội dung thanh toán</th>
                    <th class="text-center" style="width: 15%;">Số lượng</th>
                    <th class="text-right" style="width: 20%;">Đơn giá</th>
                    <th class="text-right" style="width: 25%;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $start = \Carbon\Carbon::parse($booking->start_time);
                    $end = \Carbon\Carbon::parse($booking->end_time);
                    $hours = $start->diffInMinutes($end) / 60;
                @endphp
                <tr>
                    <td>Tiền thuê sân (Cỏ nhân tạo chất lượng cao)</td>
                    <td class="text-center">{{ $hours }} giờ</td>
                    <td class="text-right">{{ number_format($booking->field->price_per_hour, 0, ',', '.') }} đ</td>
                    <td class="text-right">{{ number_format($hours * $booking->field->price_per_hour, 0, ',', '.') }} đ</td>
                </tr>

                @if($booking->services->count() > 0)
                    @foreach($booking->services as $service)
                    <tr>
                        <td style="color: #4b5563;">Dịch vụ: {{ $service->name }}</td>
                        <td class="text-center" style="color: #4b5563;">{{ $service->pivot->quantity }}</td>
                        <td class="text-right" style="color: #4b5563;">{{ number_format($service->pivot->price, 0, ',', '.') }} đ</td>
                        <td class="text-right" style="color: #4b5563;">{{ number_format($service->pivot->price * $service->pivot->quantity, 0, ',', '.') }} đ</td>
                    </tr>
                    @endforeach
                @endif

                <tr class="total-row">
                    <td colspan="3" class="text-right">TỔNG CỘNG:</td>
                    <td class="text-right">{{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</td>
                </tr>
            </tbody>
        </table>

        <table style="width: 100%; margin-top: 10px; margin-bottom: 40px;">
            <tr>
                <td>
                    Trạng thái đơn: 
                    <span style="font-weight: bold; color: {{ $booking->status == 'completed' ? '#16a34a' : '#dfa100' }}">
                        {{ $booking->status == 'completed' ? 'Đã hoàn tất trận đấu' : 'Đơn đã xác nhận' }}
                    </span>
                </td>
                <td style="text-align: right;">
                    Thanh toán: 
                    <span style="font-weight: bold;">
                        {{ ($booking->payment && $booking->payment->payment_status == 'paid') ? 'ĐÃ THANH TOÁN' : 'CHƯA THANH TOÁN' }}
                    </span>
                </td>
            </tr>
        </table>

        <div class="footer-note">
            Cảm ơn bạn đã tin tưởng và sử dụng hệ thống sân bóng của PolyPitch!<br>
            Hóa đơn điện tử này được xuất tự động phục vụ mục đích kiểm kê quỹ đội bóng.
        </div>
    </div>

</body>
</html>