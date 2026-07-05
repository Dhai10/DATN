@extends('layouts.app')

@section('page-title', 'Sửa Sân Bóng')

@section('content')
    <div class="custom-card">
        <div class="custom-card-header">
            <h5><i class="fas fa-edit me-2"></i> Sửa Sân Bóng</h5>
        </div>
        <div class="custom-card-body">
            <form method="POST" action="{{ route('admin.fields.update', $field) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label fw-semibold">Tên Sân</label>
                    <input type="text" name="name" class="form-control" value="{{ $field->name }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Loại Sân</label>
                    <select name="type" class="form-select" required>
                        <option value="5 người" {{ $field->type == '5 người' ? 'selected' : '' }}>5 người</option>
                        <option value="7 người" {{ $field->type == '7 người' ? 'selected' : '' }}>7 người</option>
                        <option value="11 người" {{ $field->type == '11 người' ? 'selected' : '' }}>11 người</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Giá/Giờ (VNĐ)</label>
                    <input type="number" name="price_per_hour" class="form-control" value="{{ $field->price_per_hour }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Mô Tả</label>
                    <textarea name="description" class="form-control" rows="3">{{ $field->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Hình Ảnh</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="fas fa-save me-2"></i> Cập Nhật
                    </button>
                    <a href="{{ route('admin.fields') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left me-2"></i> Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
