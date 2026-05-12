<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.lab.bookings.show', ['booking' => $booking]);
    }

    public function update(Request $request, LabBooking $booking)
    {
        $data = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'booking_status' => 'required|in:pending,confirmed,sample_collected,completed,cancelled',
            'admin_remarks' => 'nullable|string',
        ]);

        \Log::info('Admin LabBooking update request', ['id' => $booking->id, 'input' => $data]);

        $booking->update($data);

        \Log::info('Admin LabBooking updated', ['id' => $booking->id, 'booking' => $booking->toArray()]);

        // Notify patient about status/payment change
        if ($booking->user_id) {
            \App\Models\Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking updated',
                'message' => "Your lab booking #LB-{$booking->id} status updated to " . ucfirst($booking->booking_status),
                'type' => 'booking_status',
            ]);
        }

        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            $booking->refresh();
            return response()->json(['success' => true, 'booking' => $booking]);
        }

        return back()->with('success', 'Booking updated successfully.');
    }

    public function updateReport(Request $request, LabBooking $booking)
    {
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($booking->report_file && Storage::disk('public')->exists($booking->report_file)) {
            Storage::disk('public')->delete($booking->report_file);
        }

        $path = $request->file('report_file')->store('booking-reports/lab', 'public');
        $booking->update([
            'report_file' => $path,
            'report_uploaded_at' => now(),
            'booking_status' => 'completed'
        ]);

        if ($booking->user_id) {
            \App\Models\Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Report uploaded',
                'message' => "Your lab booking #LB-{$booking->id} report is now available.",
                'type' => 'report',
            ]);
        }

        return back()->with('success', 'Lab booking report uploaded successfully.');
    }

    public function destroy(LabBooking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.lab-bookings.index')->with('success', 'Booking deleted.');
    }
}
