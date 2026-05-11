<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabBooking;
use Illuminate\Http\Request;

class LabBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = LabBooking::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('patient_name', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('booking_status')) {
            $query->where('booking_status', $request->booking_status);
        }

        $bookings = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.lab.bookings.index', compact('bookings'));
    }

    public function show(LabBooking $booking)
    {
        return view('admin.lab.bookings.show', compact('booking'));
    }

    public function update(Request $request, LabBooking $booking)
    {
        $data = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'booking_status' => 'required|in:pending,confirmed,sample_collected,completed,cancelled',
        ]);

        $booking->update($data);

        return back()->with('success', 'Booking updated successfully.');
    }

    public function destroy(LabBooking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.lab-bookings.index')->with('success', 'Booking deleted.');
    }
}
