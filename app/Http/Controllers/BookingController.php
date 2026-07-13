<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    // 1. Hiển thị form đặt sân
    public function create($id)
    {
        $field = Field::findOrFail($id);
        
        // Lấy danh sách các dịch vụ đang mở bán để khách hàng chọn (Nước, Áo, Bóng...)
        $services = Service::where('is_active', true)->get();
        
        return view('bookings.create', compact('field', 'services'));
    }

   // 2. Xử lý lưu thông tin đặt sân
    public function store(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào (Start time phải từ hiện tại trở đi, End time phải sau Start time)
        $request->validate([
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'payment_method' => 'required|in:cash',
        ], [
            'start_time.after_or_equal' => 'Giờ bắt đầu không được nằm trong quá khứ.',
            'end_time.after' => 'Giờ kết thúc phải diễn ra sau giờ bắt đầu.'
        ]);

        $field = Field::findOrFail($id);
        
        // --- TÍNH TOÁN TIỀN SÂN ---
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        
        // Lấy số phút (đặt $start trước $end để luôn ra số dương)
        $minutes = $start->diffInMinutes($end);
        
        // Bắt buộc thuê ít nhất 1 tiếng (60 phút)
        if ($minutes < 60) {
            return back()->withInput()->withErrors(['end_time' => 'Thời gian thuê sân tối thiểu phải là 1 tiếng (60 phút).']);
        }

        // ==========================================
        // KHỐI KIỂM TRA TRÙNG LỊCH ĐẶT SÂN
        // ==========================================
        $isOverlapped = Booking::where('field_id', $field->id)
            ->whereIn('status', ['pending', 'confirmed']) // Chỉ xét các đơn chờ duyệt hoặc đã duyệt
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    // Trường hợp 1: Giờ bắt đầu mới nằm giữa một khung giờ đã đặt
                    $q->where('start_time', '<=', $request->start_time)
                      ->where('end_time', '>', $request->start_time);
                })
                ->orWhere(function ($q) use ($request) {
                    // Trường hợp 2: Giờ kết thúc mới nằm giữa một khung giờ đã đặt
                    $q->where('start_time', '<', $request->end_time)
                      ->where('end_time', '>=', $request->end_time);
                })
                ->orWhere(function ($q) use ($request) {
                    // Trường hợp 3: Khung giờ mới bao trọn khung giờ đã đặt cũ
                    $q->where('start_time', '>=', $request->start_time)
                      ->where('end_time', '<=', $request->end_time);
                });
            })
            ->exists();

        if ($isOverlapped) {
            return back()->withInput()->withErrors(['start_time' => 'Khung giờ này đã có đội khác đặt sân. Vui lòng kiểm tra lại lịch trống bên dưới!']);
        }
        // ==========================================

        // Lấy số giờ đá (Ví dụ: 90 phút / 60 = 1.5 giờ)
        $hours = $minutes / 60;
        $fieldPrice = $hours * $field->price_per_hour;
        
        // --- TÍNH TOÁN TIỀN DỊCH VỤ (nếu có) ---
        $servicesPrice = 0;
        $serviceData = []; // Mảng chuẩn bị để lưu vào bảng trung gian booking_services
        
        if ($request->has('services')) {
            foreach ($request->services as $serviceId => $data) {
                // Kiểm tra xem khách có tích chọn checkbox (có id) không
                if (isset($data['id'])) {
                    $service = Service::find($serviceId);
                    if ($service) {
                        $quantity = max(1, (int)$data['quantity']); // Lấy số lượng, ít nhất là 1
                        $price = $service->price;
                        
                        $servicesPrice += ($price * $quantity);
                        
                        // Đưa vào mảng dữ liệu để attach
                        $serviceData[$serviceId] = [
                            'quantity' => $quantity,
                            'price' => $price
                        ];
                    }
                }
            }
        }
        
        $totalPrice = $fieldPrice + $servicesPrice;

        // --- BẮT ĐẦU LƯU VÀO DATABASE ---
        
        // A. Lưu bảng bookings
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'field_id' => $field->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        // B. Lưu các dịch vụ vào bảng trung gian booking_services
        if (!empty($serviceData)) {
            $booking->services()->attach($serviceData);
        }

        // C. Tạo bản ghi thanh toán trong bảng payments
        $booking->payment()->create([
            'amount' => $totalPrice,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending'
        ]);

        // Điều hướng khách về trang lịch sử
        return redirect()->route('bookings.index')->with('status', 'Đặt sân thành công! Vui lòng chờ chủ sân xác nhận.');
    }

    // 3. Hiển thị lịch sử đặt sân của Khách hàng
    public function index()
    {
        $bookings = Booking::with('field')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    // 4. Hiển thị chi tiết Đơn đặt sân (Hóa đơn/Biên lai)
    public function show($id)
    {
        $booking = Booking::with(['field', 'services', 'payment'])->findOrFail($id);

        // Bảo mật: Chỉ cho phép chủ nhân đơn hàng hoặc Admin xem
        if ($booking->user_id !== auth()->id() && auth()->user()->role_id !== 1) {
            abort(403, 'Bạn không có quyền xem hóa đơn này!');
        }

        return view('bookings.show', compact('booking'));
    }

    // 5. Xử lý Khách hàng tự hủy đơn
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        // Bảo mật: Kiểm tra xem đơn này có đúng là của user đang đăng nhập không
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền hủy đơn đặt sân của người khác!');
        }

        // Logic: Chỉ cho phép hủy nếu trạng thái đang là 'pending'
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Bạn chỉ có thể tự hủy khi đơn đang chờ xác nhận. Nếu cần thiết, vui lòng liên hệ Admin.']);
        }

        // Thực thi: Cập nhật trạng thái thành cancelled
        $booking->update(['status' => 'cancelled']);
        
        // Đổi trạng thái thanh toán thành failed
        if($booking->payment) {
            $booking->payment->update(['payment_status' => 'failed']);
        }

        return back()->with('status', 'Bạn đã hủy đơn đặt sân thành công!');
    }

    // Xuất đơn đặt sân ra file PDF chuyên nghiệp
    public function downloadPDF($id)
    {
        // Lấy thông tin đơn hàng đầy đủ
        $booking = Booking::with(['field', 'services', 'payment', 'user'])->findOrFail($id);

        // Bảo mật: Chỉ chủ đơn hoặc Admin mới được phép tải file này
        if ($booking->user_id !== auth()->id() && auth()->user()->role_id !== 1) {
            abort(403, 'Bạn không có quyền tải hóa đơn này!');
        }

        // Truyền dữ liệu vào một file view giao diện riêng dành cho PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bookings.pdf', compact('booking'));
        
        // Trả về file PDF tải xuống trực tiếp trên trình duyệt
        return $pdf->download('HoaDon_PolyPitch_#' . $booking->id . '.pdf');
    }
}