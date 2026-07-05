@extends('customer.layouts.app')

@section('page-title', 'Đặt Sân')

@section('content')
    <!-- Page Header -->
    <section class="hero-section" style="padding: 40px 0;">
        <div class="container">
            <h1 class="display-4 fw-bold mb-2">Đặt Sân</h1>
            <p class="lead opacity-90 mb-0">Đặt sân: {{ $field->name }}</p>
        </div>
    </section>

    <section class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card p-4">
                        <div class="mb-4">
                            <strong class="fs-5">Giá mỗi giờ:</strong>
                            <span class="text-primary fs-5 fw-bold ms-2">{{ number_format($field->price_per_hour, 0, ',', '.') }} đ</span>
                        </div>

                        <form method="POST" action="{{ route('customer.bookings.store') }}">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $field->id }}">

                            <div class="mb-4">
                                <label for="booking_date" class="form-label fw-semibold">Ngày Đặt</label>
                                <input id="booking_date" type="date" class="form-control" name="booking_date" value="{{ old('booking_date') }}" required>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label fw-semibold">Giờ Bắt Đầu</label>
                                    <input id="start_time" type="time" class="form-control" name="start_time" value="{{ old('start_time') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_time" class="form-label fw-semibold">Giờ Kết Thúc</label>
                                    <input id="end_time" type="time" class="form-control" name="end_time" value="{{ old('end_time') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="notes" class="form-label fw-semibold">Ghi Chú (nếu có)</label>
                                <textarea id="notes" class="form-control" name="notes" rows="3">{{ old('notes') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-start gap-3">
                                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i> Quay Lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i> Xác Nhận Đặt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
