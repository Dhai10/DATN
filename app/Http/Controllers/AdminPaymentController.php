<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    // Hiển thị danh sách tất cả giao dịch
    public function index()
    {
        // Lấy danh sách giao dịch, kèm thông tin Booking và Khách hàng (User)
        $payments = Payment::with('booking.user')->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.payments.index', compact('payments'));
    }

    // Cập nhật trạng thái thanh toán thủ công (nếu cần)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update(['payment_status' => $request->payment_status]);

        return back()->with('status', 'Đã cập nhật trạng thái thanh toán thành công!');
    }
}