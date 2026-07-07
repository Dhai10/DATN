@extends('customer.layouts.app')

@section('page-title', $field->name)

@section('content')
    <style>
        .field-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 40px 0;
        }
        .time-slot {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .time-slot:hover:not(.booked):not(.selected) {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: #3b82f6;
        }
        .time-slot.selected {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #059669;
        }
        .time-slot.booked {
            background: #fee2e2;
            color: #991b1b;
            cursor: not-allowed;
            border-color: #fca5a5;
        }
        .sidebar-summary {
            position: sticky;
            top: 20px;
        }
    </style>

    <!-- Header -->
    <div class="field-header">
        <div class="container">
            <a href="{{ route('customer.dashboard') }}" class="text-white text-decoration-none mb-3 d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Quay lại
            </a>
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="field-image" style="width: 100px; height: 100px; border-radius: 16px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-futbol" style="font-size: 3rem; color: #64748b;"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-1">{{ $field->name }}</h1>
                            <div class="d-flex align-items-center gap-3 opacity-90">
                                <span class="badge bg-white text-primary fw-semibold">{{ $field->type }}</span>
                                <span><i class="fas fa-map-marker-alt me-1"></i> Hà Nội</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content" data-field-price="{{ $field->price_per_hour }}" data-field-id="{{ $field->id }}" data-field-show-url="{{ route('customer.fields.show', $field) }}" data-checkout-url="{{ route('customer.bookings.checkout', $field) }}">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Field Info -->
                    <div class="card p-4 mb-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Thông tin sân</h5>
                        <p class="text-muted mb-3">{{ $field->description ?? 'Sân bóng chất lượng cao với đầy đủ tiện nghi.' }}</p>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-wind text-success"></i>
                                    <span>Phòng thay đồ</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-parking text-success"></i>
                                    <span>Bãi đỗ xe</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-lightbulb text-success"></i>
                                    <span>Đèn chiếu sáng</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar & Time Slots -->
                    <div class="card p-4 mb-4">
                        <h5 class="fw-bold mb-3"><i class="fas fa-calendar-alt me-2 text-primary"></i> Chọn lịch đặt sân</h5>
                        
                        <!-- Date Picker -->
                        <div class="mb-4">
                            <input type="date" id="bookingDate" class="form-control" style="max-width: 300px;" min="{{ date('Y-m-d') }}" value="{{ $selectedDate }}">
                        </div>

                        <!-- Time Slots -->
                        <h6 class="fw-semibold mb-3">Khung giờ có sẵn</h6>
                        <div class="row g-3" id="timeSlots">
                            @php
                                $timeSlots = [
                                    ['06:00', '07:00'],
                                    ['07:00', '08:00'],
                                    ['08:00', '09:00'],
                                    ['09:00', '10:00'],
                                    ['10:00', '11:00'],
                                    ['11:00', '12:00'],
                                    ['14:00', '15:00'],
                                    ['15:00', '16:00'],
                                    ['16:00', '17:00'],
                                    ['17:00', '18:00'],
                                    ['18:00', '19:00'],
                                    ['19:00', '20:00'],
                                    ['20:00', '21:00'],
                                    ['21:00', '22:00'],
                                ];
                                
                                // Create array of booked time ranges
                                $bookedSlots = [];
                                foreach ($bookings as $booking) {
                                    $bookedSlots[] = [
                                        'start' => substr($booking->start_time, 0, 5),
                                        'end' => substr($booking->end_time, 0, 5)
                                    ];
                                }
                            @endphp
                            @foreach($timeSlots as $slot)
                                @php
                                    $isBooked = false;
                                    foreach ($bookedSlots as $booked) {
                                        if ($slot[0] == $booked['start'] && $slot[1] == $booked['end']) {
                                            $isBooked = true;
                                            break;
                                        }
                                    }
                                @endphp
                                <div class="col-md-3">
                                    <div class="time-slot border rounded-3 p-3 text-center {{ $isBooked ? 'booked' : '' }}" data-start="{{ $slot[0] }}" data-end="{{ $slot[1] }}">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $slot[0] }} - {{ $slot[1] }}
                                        <div class="fw-bold {{ $isBooked ? 'text-danger' : 'text-primary' }} mt-1">
                                            {{ number_format($field->price_per_hour, 0, ',', '.') }} đ
                                        </div>
                                        @if($isBooked)
                                            <div class="small text-danger">Đã đặt</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar Summary -->
                <div class="col-lg-4">
                    <div class="card sidebar-summary p-4">
                        <h5 class="fw-bold mb-3">Tóm tắt đơn hàng</h5>
                        
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                            <div class="field-image" style="width: 60px; height: 60px; border-radius: 12px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-futbol" style="color: #64748b;"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $field->name }}</div>
                                <small class="text-muted">{{ $field->type }}</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <small class="text-muted"><i class="far fa-calendar me-1"></i> Ngày đã chọn</small>
                                <span id="selectedDate" class="fw-semibold">{{ date('d/m/Y', strtotime($selectedDate)) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted"><i class="far fa-clock me-1"></i> Khung giờ đã chọn</small>
                                <span id="selectedTime" class="fw-semibold">Chưa chọn</span>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5">Tổng cộng</span>
                                <span id="totalPrice" class="fw-bold fs-4 text-primary">0 đ</span>
                            </div>
                        </div>

                        <button id="bookNowBtn" class="btn btn-primary w-100 btn-lg" disabled style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); opacity: 0.5;">
                            <i class="fas fa-calendar-check me-2"></i> Đặt sân ngay
                        </button>
                        <small class="text-muted d-block text-center mt-2">Bạn chưa bấm chọn giờ để đặt sân</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedSlot = null;
        const pageContent = document.querySelector('.page-content');
        const fieldPrice = parseFloat(pageContent.dataset.fieldPrice);
        const fieldId = pageContent.dataset.fieldId;
        const fieldShowUrl = pageContent.dataset.fieldShowUrl;
        const checkoutUrl = pageContent.dataset.checkoutUrl;

        // Update selected date
        document.getElementById('bookingDate').addEventListener('change', function() {
            window.location.href = fieldShowUrl + '?date=' + this.value;
        });

        // Time slot selection
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.addEventListener('click', function() {
                if (this.classList.contains('booked')) return;
                
                document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
                this.classList.add('selected');
                selectedSlot = {
                    start: this.dataset.start,
                    end: this.dataset.end
                };
                
                const timeText = selectedSlot.start + ' - ' + selectedSlot.end;
                document.getElementById('selectedTime').textContent = timeText;
                
                const total = fieldPrice;
                document.getElementById('totalPrice').textContent = total.toLocaleString('vi-VN') + ' đ';
                
                const bookBtn = document.getElementById('bookNowBtn');
                bookBtn.disabled = false;
                bookBtn.style.opacity = '1';
                bookBtn.nextElementSibling.style.display = 'none';
            });
        });

        // Reset selection
        function resetSelection() {
            selectedSlot = null;
            document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
            document.getElementById('selectedTime').textContent = 'Chưa chọn';
            document.getElementById('totalPrice').textContent = '0 đ';
            
            const bookBtn = document.getElementById('bookNowBtn');
            bookBtn.disabled = true;
            bookBtn.style.opacity = '0.5';
            bookBtn.nextElementSibling.style.display = 'block';
        }

        // Book now button
        document.getElementById('bookNowBtn').addEventListener('click', function() {
            if (!selectedSlot) return;
            
            const dateInput = document.getElementById('bookingDate').value;
            window.location.href = checkoutUrl + '?date=' + dateInput + '&start_time=' + selectedSlot.start + '&end_time=' + selectedSlot.end;
        });
    </script>
@endsection
