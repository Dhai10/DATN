<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Field;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalFields' => Field::count(),
            'totalBookings' => Booking::count(),
            'totalRevenue' => Booking::where('status', 'completed')->sum('total_price'),
        ];
        $recentBookings = Booking::with(['user', 'field'])->latest()->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function fields()
    {
        $fields = Field::all();
        return view('admin.fields', compact('fields'));
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'field'])->get();
        return view('admin.bookings', compact('bookings'));
    }
}
