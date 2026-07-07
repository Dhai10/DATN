<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @property-read User|null $user
 */
class BookingController extends Controller
{
    public function create(Field $field)
    {
        return view('customer.bookings-create', compact('field'));
    }

    public function checkout(Request $request, Field $field)
    {
        $date = $request->query('date');
        $startTime = $request->query('start_time');
        $endTime = $request->query('end_time');
        
        $start = strtotime($startTime);
        $end = strtotime($endTime);
        $hours = ($end - $start) / 3600;
        $totalPrice = $hours * $field->price_per_hour;
        
        return view('customer.bookings-checkout', compact('field', 'date', 'startTime', 'endTime', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'notes' => 'nullable',
        ]);

        $field = Field::findOrFail($request->field_id);
        
        $start = strtotime($request->start_time);
        $end = strtotime($request->end_time);
        $hours = ($end - $start) / 3600;
        $totalPrice = $hours * $field->price_per_hour;

        /** @var User $authUser */
        $authUser = auth()->user();
        Booking::create([
            'user_id' => $authUser->id,
            'field_id' => $request->field_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Đặt sân thành công!');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Trạng thái đã được cập nhật!');
    }
}
