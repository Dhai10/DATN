@extends('customer.layouts.app')

@section('page-title', 'Trang Chủ')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Chào mừng, {{ Auth::user()->name }}!</h1>
                    <p class="lead mb-4 opacity-90">Đặt sân bóng một cách nhanh chóng và tiện lợi. Khám phá các sân bóng hiện đại của chúng tôi ngay hôm nay!</p>
                    <a href="#fields" class="btn btn-light btn-lg fw-bold px-5">
                        <i class="fas fa-calendar-plus me-2"></i> Đặt Sân Ngay
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-futbol" style="font-size: 12rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="page-content" style="background: white; margin-top: -30px;">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 60px; height: 60px; border-radius: 14px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.6rem;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $stats['totalBookings'] }}</h3>
                                <p class="text-muted mb-0">Tổng Lịch Đặt</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 60px; height: 60px; border-radius: 14px; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.6rem;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $stats['confirmedBookings'] }}</h3>
                                <p class="text-muted mb-0">Đã Xác Nhận</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fields Section -->
    <section id="fields" class="page-content">
        <div class="container">
            <h2 class="fw-bold mb-4"><i class="fas fa-layer-group me-2"></i> Danh Sách Sân Bóng</h2>
            <div class="row g-4">
                @foreach($fields as $field)
                    <div class="col-lg-4 col-md-6">
                        <div class="card field-card">
                            <div class="field-image">
                                <i class="fas fa-futbol"></i>
                            </div>
                            <div class="card-body p-4">
                                <h4 class="fw-bold mb-2">{{ $field->name }}</h4>
                                <p class="text-muted mb-3">{{ $field->type }}</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-bold text-primary mb-0">{{ number_format($field->price_per_hour, 0, ',', '.') }} đ/giờ</h5>
                                    @if($field->is_active)
                                        <span class="badge badge-confirmed">Đang Mở</span>
                                    @else
                                        <span class="badge badge-cancelled">Đóng</span>
                                    @endif
                                </div>
                                <a href="{{ route('customer.fields.show', $field) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-calendar-plus me-2"></i> Đặt sân ngay
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recent Bookings Section -->
    <section class="page-content" style="background: white;">
        <div class="container">
            <h2 class="fw-bold mb-4"><i class="fas fa-clock me-2"></i> Lịch Đặt Gần Đây</h2>
            @if(count($recentBookings) > 0)
                <div class="row g-4">
                    @foreach($recentBookings as $booking)
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
                    <a href="#fields" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-2"></i> Đặt Sân Ngay
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
