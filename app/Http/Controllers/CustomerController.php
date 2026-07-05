<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @property-read User|null $user
 */
class CustomerController extends Controller
{
    public function dashboard()
    {
        /** @var User $authUser */
        $authUser = auth()->user();
        $fields = Field::where('is_active', true)->get();
        $recentBookings = Booking::where('user_id', $authUser->id)->latest()->take(5)->get();
        
        $stats = [
            'totalBookings' => Booking::where('user_id', $authUser->id)->count(),
            'confirmedBookings' => Booking::where('user_id', $authUser->id)->where('status', 'confirmed')->count(),
        ];
        
        return view('customer.dashboard', compact('fields', 'recentBookings', 'stats'));
    }

    public function myBookings()
    {
        /** @var User $authUser */
        $authUser = auth()->user();
        $bookings = Booking::where('user_id', $authUser->id)->latest()->get();
        return view('customer.bookings', compact('bookings'));
    }

    public function showField(Field $field, Request $request)
    {
        $selectedDate = $request->query('date', date('Y-m-d'));
        $bookings = Booking::where('field_id', $field->id)
            ->where('booking_date', $selectedDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();
        
        return view('customer.fields.show', compact('field', 'bookings', 'selectedDate'));
    }
}
