<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldType;
use Illuminate\Http\Request;

class FieldController extends Controller
{
   public function index(Request $request)
    {
        // 1. Khởi tạo câu truy vấn cơ bản (chỉ lấy sân đang mở)
        $query = Field::with('fieldType')->where('is_active', true);
        
        // 2. Nếu khách hàng có bấm chọn lọc theo Loại sân (type)
        if ($request->has('type') && $request->type != '') {
            $query->where('field_type_id', $request->type);
        }
        
        // 3. Thực thi truy vấn lấy kết quả
        $fields = $query->get();
        
        // 4. Lấy danh sách Loại sân để hiển thị ra thanh Dropdown (Select)
        $fieldTypes = FieldType::all();
        
        return view('dashboard', compact('fields', 'fieldTypes'));
    }
    // Hiển thị Trang chi tiết Sân bóng
    public function show($id)
    {
        // Lấy thông tin sân cùng loại sân
        $field = Field::with('fieldType')->findOrFail($id);
        
        // Trả về view chi tiết
        return view('fields.show', compact('field'));
    }
    // API trả về danh sách giờ đã được đặt của một sân
    public function getBookings($id)
    {
        // Lấy các đơn đặt sân đang chờ duyệt hoặc đã xác nhận
        $bookings = \App\Models\Booking::where('field_id', $id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        $events = [];
        foreach ($bookings as $booking) {
            $events[] = [
                'title' => 'Đã có người đặt',
                'start' => $booking->start_time,
                'end' => $booking->end_time,
                'color' => '#ef4444', // Màu đỏ báo hiệu đã kín lịch
                'display' => 'block'
            ];
        }

        return response()->json($events);
    }
}