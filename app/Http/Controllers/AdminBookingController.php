<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // Hiển thị danh sách tất cả đơn đặt sân
    public function index()
    {
        // Lấy danh sách booking, kèm thông tin User và Field, sắp xếp mới nhất lên đầu, phân trang 10 dòng
        $bookings = Booking::with(['user', 'field'])->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    // Xử lý cập nhật trạng thái đơn (Duyệt, Hoàn thành, Hủy)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        // Nếu trạng thái là completed (Đã đá xong), cập nhật luôn bảng payment thành paid (Đã thanh toán)
        if ($request->status == 'completed' && $booking->payment) {
            $booking->payment->update(['payment_status' => 'paid']);
        }

        // Nếu admin hủy đơn, cập nhật thanh toán thành failed
        if ($request->status == 'cancelled' && $booking->payment) {
            $booking->payment->update(['payment_status' => 'failed']);
        }

        return back()->with('status', 'Cập nhật trạng thái đơn đặt sân thành công!');
    }
}