@extends('layouts.app')

@section('page-title', 'Quản Lý Sân Bóng')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4></h4>
        <a href="{{ route('admin.fields.create') }}" class="btn btn-gradient-primary">
            <i class="fas fa-plus me-2"></i> Thêm Sân Bóng
        </a>
    </div>

    <div class="custom-card">
        <div class="custom-card-header">
            <h5><i class="fas fa-layer-group me-2"></i> Danh Sách Sân Bóng</h5>
        </div>
        <div class="custom-card-body p-0">
            <div class="table-container">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Sân</th>
                            <th>Loại</th>
                            <th>Giá/Giờ</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fields as $field)
                        <tr>
                            <td>{{ $field->id }}</td>
                            <td>{{ $field->name }}</td>
                            <td>{{ $field->type }}</td>
                            <td>{{ number_format($field->price_per_hour, 0, ',', '.') }} đ</td>
                            <td>
                                @if($field->is_active)
                                    <span class="badge badge-confirmed">Hoạt Động</span>
                                @else
                                    <span class="badge badge-cancelled">Không Hoạt Động</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.fields.edit', $field) }}" class="btn btn-sm btn-outline">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
