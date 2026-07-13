<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Xử lý yêu cầu truy cập.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra 2 điều kiện: Đã đăng nhập VÀ có role_id = 1 (Admin)
        if (auth()->check() && auth()->user()->role_id == 1) {
            return $next($request); // Cho phép đi tiếp vào trang Admin
        }

        // Nếu không phải Admin, báo lỗi 403 (Cấm truy cập) 
        // Hoặc bạn có thể dùng lệnh: return redirect('/dashboard'); để đuổi về trang chủ khách hàng
        abort(403, 'CẢNH BÁO: Bạn không có quyền truy cập vào khu vực Quản trị viên!');
    }
}