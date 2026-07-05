@extends('customer.layouts.app')

@section('page-title', 'Thanh toán đặt sân')

@section('content')
    <style>
        .checkout-header {
            background: #f8fafc;
            padding: 30px 0;
        }
        .payment-method {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-method:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
        }
        .payment-method.selected {
            border-color: #10b981;
            background: #ecfdf5;
        }
    </style>

    <!-- Header -->
    <div class="checkout-header">
        <div class="container">
            <a href="{{ route('customer.fields.show', $field) }}" class="text-decoration-none text-muted mb-3 d-inline-flex align-items-center">
                <i class="fas fa-arrow-left me-2"></i> Quay lại
            </a>
            <h1 class="fw-bold">Thanh toán đặt sân</h1>
        </div>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Booking Info -->
                    <div class="card p-4 mb-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-calendar-check me-2 text-primary"></i> Thông tin đặt sân</h5>
                        
                        <div class="d-flex align-items-center gap-4">
                            <div class="field-image" style="width: 120px; height: 120px; border-radius: 16px; background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-futbol" style="font-size: 3rem; color: #64748b;"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-2">{{ $field->name }}</h4>
                                <div class="d-flex gap-3 mb-2 text-muted">
                                    <span><i class="fas fa-map-marker-alt me-1"></i> Hà Nội</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success text-white rounded-pill px-3 py-1">
                                        <i class="far fa-clock me-1"></i> {{ date('H:i', strtotime($startTime)) }} - {{ date('H:i', strtotime($endTime)) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="card p-4 mb-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-user me-2 text-primary"></i> Thông tin người đặt</h5>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold"><i class="fas fa-user-tag me-1 text-muted"></i> Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly style="background: #eff6ff;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold"><i class="fas fa-phone me-1 text-muted"></i> Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại">
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                <i class="far fa-sticky-note text-muted"></i> Ghi chú
                            </label>
                            <textarea id="notes" class="form-control" rows="3" placeholder="Ghi chú thêm (không bắt buộc)"></textarea>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="card p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-credit-card me-2 text-primary"></i> Phương thức thanh toán</h5>
                        
                        <div class="payment-method border rounded-3 p-4 mb-3 selected" data-method="cash">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center" style="width: 48px; height: 48px; border-radius: 16px; background: #d1fae5;">
                                    <i class="fas fa-money-bill-wave text-green-600" style="color: #059669; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Thanh toán tại sân</div>
                                    <small class="text-muted">Thanh toán trực tiếp khi đến sân</small>
                                </div>
                                <div class="ms-auto">
                                    <i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                        </div>

                        <div class="payment-method border rounded-3 p-4 mb-3" data-method="momo">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-pink-100 flex items-center justify-center" style="width: 48px; height: 48px; border-radius: 16px; background: #fce7f3;">
                                    <i class="fas fa-wallet text-pink-600" style="color: #db2777; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Thanh toán MoMo</div>
                                    <small class="text-muted">Thanh toán qua ví điện tử MoMo</small>
                                </div>
                            </div>
                        </div>

                        <div class="payment-method border rounded-3 p-4" data-method="vnpay">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center" style="width: 48px; height: 48px; border-radius: 16px; background: #dbeafe;">
                                    <i class="fas fa-credit-card text-blue-600" style="color: #2563eb; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Thanh toán VNPay</div>
                                    <small class="text-muted">Thanh toán qua cổng VNPay</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Summary -->
                <div class="col-lg-4">
                    <div class="card p-4" style="position: sticky; top: 20px;">
                        <h5 class="fw-bold mb-4">Tóm tắt đơn hàng</h5>
                        
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
                                <span class="text-muted">{{ date('H:i', strtotime($startTime)) }} - {{ date('H:i', strtotime($endTime)) }}</span>
                                <span class="fw-semibold">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold d-flex align-items-center gap-2">
                                <i class="far fa-clock text-muted"></i> Mã giảm giá
                            </label>
                            <div class="d-flex gap-2">
                                <input type="text" class="form-control" placeholder="Nhập mã">
                                <button class="btn btn-success" style="white-space: nowrap;">Áp dụng</button>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính</span>
                                <span>{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Phí dịch vụ</span>
                                <span class="text-success">Miễn phí</span>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold fs-5">Tổng cộng</span>
                                <span class="fw-bold fs-3 text-success">{{ number_format($totalPrice, 0, ',', '.') }} đ</span>
                            </div>
                        </div>

                        <form id="checkoutForm" method="POST" action="{{ route('customer.bookings.store') }}">
                            @csrf
                            <input type="hidden" name="field_id" value="{{ $field->id }}">
                            <input type="hidden" name="booking_date" value="{{ $date }}">
                            <input type="hidden" name="start_time" value="{{ $startTime }}">
                            <input type="hidden" name="end_time" value="{{ $endTime }}">
                            <input type="hidden" name="notes" id="notesInput">
                            
                            <button type="submit" class="btn btn-success w-100 btn-lg" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                                <i class="fas fa-check-circle me-2"></i> Xác nhận thanh toán
                            </button>
                        </form>

                        <small class="text-muted d-block text-center mt-3">
                            Bằng việc đặt sân, bạn đồng ý với điều khoản dịch vụ
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('selected');
                    const checkIcon = m.querySelector('.fa-check-circle');
                    if (checkIcon) checkIcon.remove();
                });
                
                this.classList.add('selected');
                
                // Add check icon
                if (!this.querySelector('.fa-check-circle')) {
                    const container = this.querySelector('.ms-auto');
                    if (!container) {
                        const newContainer = document.createElement('div');
                        newContainer.className = 'ms-auto';
                        newContainer.innerHTML = '<i class="fas fa-check-circle text-success" style="font-size: 1.5rem;"></i>';
                        this.querySelector('.d-flex').appendChild(newContainer);
                    }
                }
            });
        });

        // Sync notes to hidden input
        document.getElementById('notes').addEventListener('input', function() {
            document.getElementById('notesInput').value = this.value;
        });

        // Form submission
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const phone = document.getElementById('phone').value;
            if (!phone.trim()) {
                e.preventDefault();
                alert('Vui lòng nhập số điện thoại!');
                document.getElementById('phone').focus();
                return;
            }
        });
    </script>
@endsection
