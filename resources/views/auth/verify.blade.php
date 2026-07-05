@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white py-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    <h4 class="mb-0 fw-bold text-center">Xác Minh Địa Chỉ Email</h4>
                </div>

                <div class="card-body p-5">
                    @if (session('resent'))
                        <div class="alert alert-success mb-4" role="alert">
                            Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.
                        </div>
                    @endif

                    <p class="mb-4">Trước khi tiếp tục, vui lòng kiểm tra email của bạn để lấy liên kết xác minh.</p>
                    <p class="mb-4">Nếu bạn không nhận được email,</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-decoration-none fw-semibold">
                            nhấn vào đây để yêu cầu một liên kết khác
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
