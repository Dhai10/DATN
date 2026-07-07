@extends('customer.layouts.app')

@section('page-title', 'Lịch Đặt Của Tôi')

@section('content')
    <!-- Page Header -->
    <section class="hero-section" style="padding: 40px 0;">
        <div class="container">
            <h1 class="display-4 fw-bold mb-2">Lịch Đặt Của Tôi</h1>
            <p class="lead opacity-90 mb-0">Quản lý tất cả lịch đặt sân bóng của bạn</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            @if(count($bookings) > 0)
                <div class="row g-4">
                    @foreach($bookings as $booking)
                        <div class="col-lg-4 col-md-6">
                            <div class="card p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $booking->field->name }}</h5>
                                        <small class="text-muted">#{{ $booking->id }}</small>
                                    </div>
                                    @if($booking->status == 'pending')
                                        <span class="badge badge-pending">Chờ xác nhận</span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="badge badge-confirmed">Đã xác nhận</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge badge-completed">Hoàn thành</span>
                                    @else
                                        <span class="badge badge-cancelled">Hủy</span>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <i class="fas fa-calendar-alt me-2 text-muted"></i> {{ date('d/m/Y', strtotime($booking->booking_date)) }}
                                </div>
                                <div class="mb-3">
                                    <i class="fas fa-clock me-2 text-muted"></i> {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold fs-5 text-primary">{{ number_format($booking->total_price, 0, ',', '.') }} đ</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card p-5 text-center">
                    <i class="fas fa-calendar-times" style="font-size: 4rem; color: #cbd5e1;"></i>
                    <h4 class="mt-3 mb-2">Chưa có lịch đặt nào</h4>
                    <p class="text-muted mb-4">Bắt đầu đặt sân ngay hôm nay!</p>
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i> Về Trang Chủ
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
