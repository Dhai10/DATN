@extends('layouts.app')

@section('page-title', 'Quản Lý Người Dùng')

@section('content')
    <div class="custom-card">
        <div class="custom-card-header">
            <h5><i class="fas fa-users me-2"></i> Danh Sách Người Dùng</h5>
        </div>
        <div class="custom-card-body p-0">
            <div class="table-container">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Vai Trò</th>
                            <th>Ngày Tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge badge-pending">Admin</span>
                                @elseif($user->role == 'employee')
                                    <span class="badge badge-confirmed">Nhân Viên</span>
                                @else
                                    <span class="badge badge-completed">Khách Hàng</span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
