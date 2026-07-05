@extends('layouts.app')

@section('page-title', 'Quản Lý Đặt Sân')

@section('content')
    <div class="custom-card">
        <div class="custom-card-header">
            <h5><i class="fas fa-calendar-check me-2"></i> Danh Sách Đơn Đặt Sân</h5>
        </div>
        <div class="custom-card-body p-0">
            <div class="table-container">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách Hàng</th>
                            <th>Sân</th>
                            <th>Ngày Đặt</th>
                            <th>Giờ</th>
                            <th>Giá</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#{{ $booking->id }}</td>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->field->name }}</td>
                            <td>{{ date('d/m/Y', strtotime($booking->booking_date)) }}</td>
                            <td>{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</td>
                            <td>{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
                            <td>
                                @if($booking->status == 'pending')
                                    <span class="badge badge-pending">Chờ xác nhận</span>
                                @elseif($booking->status == 'confirmed')
                                    <span class="badge badge-confirmed">Đã xác nhận</span>
                                @elseif($booking->status == 'completed')
                                    <span class="badge badge-completed">Hoàn thành</span>
                                @else
                                    <span class="badge badge-cancelled">Hủy</span>
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'pending')
                                    <form method="POST" action="{{ route('bookings.status', $booking) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn btn-sm btn-gradient-primary">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('bookings.status', $booking) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-sm btn-outline" style="border-color:#dc2626;color:#dc2626">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @elseif($booking->status == 'confirmed')
                                    <form method="POST" action="{{ route('bookings.status', $booking) }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-sm btn-gradient-primary">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
