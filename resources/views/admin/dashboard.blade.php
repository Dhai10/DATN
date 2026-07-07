@extends('layouts.app')

@section('page-title', 'Dashboard Admin')

@section('content')
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $stats['totalUsers'] }}</div>
                <div class="stat-label">Tổng Người Dùng</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon cyan">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-value">{{ $stats['totalFields'] }}</div>
                <div class="stat-label">Sân Bóng</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $stats['totalBookings'] }}</div>
                <div class="stat-label">Đơn Đặt Sân</div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-value">{{ number_format($stats['totalRevenue'], 0, ',', '.') }} đ</div>
                <div class="stat-label">Doanh Thu</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="custom-card">
                <div class="custom-card-header">
                    <h5><i class="fas fa-clock me-2"></i> Đơn Đặt Sân Mới Nhất</h5>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentBookings as $booking)
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
