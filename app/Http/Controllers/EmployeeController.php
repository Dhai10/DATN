<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalFields' => Field::count(),
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'totalRevenue' => Booking::where('status', 'completed')->sum('total_price'),
        ];
        $recentBookings = Booking::with(['user', 'field'])->latest()->take(5)->get();
        
        return view('employee.dashboard', compact('stats', 'recentBookings'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'field'])->get();
        return view('employee.bookings', compact('bookings'));
    }
}
