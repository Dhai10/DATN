@extends('layouts.app')

@section('page-title', 'Thêm Sân Bóng Mới')

@section('content')
    <div class="custom-card">
        <div class="custom-card-header">
            <h5><i class="fas fa-plus me-2"></i> Thêm Sân Bóng Mới</h5>
        </div>
        <div class="custom-card-body">
            <form method="POST" action="{{ route('admin.fields.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-semibold">Tên Sân</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Loại Sân</label>
                    <select name="type" class="form-select" required>
                        <option value="5 người">5 người</option>
                        <option value="7 người">7 người</option>
                        <option value="11 người">11 người</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Giá/Giờ (VNĐ)</label>
                    <input type="number" name="price_per_hour" class="form-control" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Mô Tả</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Mô tả chi tiết về sân bóng..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Hình Ảnh</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="fas fa-save me-2"></i> Lưu
                    </button>
                    <a href="{{ route('admin.fields') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left me-2"></i> Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
