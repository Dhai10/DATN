<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Lấy 4 con số thống kê tổng quan
        $totalUsers = User::where('role_id', 2)->count(); // Chỉ đếm khách hàng
        $totalFields = Field::count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');

        // 2. Tính toán doanh thu theo 6 tháng gần nhất cho Biểu đồ
        $months = [];
        $monthlyRevenue = [];
        
        for ($i = 5; $i >= 0; $i--) {
            // Lùi dần về các tháng trước
            $date = Carbon::now()->subMonths($i);
            $months[] = 'Tháng ' . $date->format('m/Y');
            
            // Tính tổng tiền các đơn 'đã thanh toán' trong tháng đó
            $revenue = Payment::where('payment_status', 'paid')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
                
            $monthlyRevenue[] = $revenue;
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalFields', 'totalBookings', 'totalRevenue', 
            'months', 'monthlyRevenue'
        ));
    }
}