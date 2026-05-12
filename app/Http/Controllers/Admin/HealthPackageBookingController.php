<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HealthPackageBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = HealthPackageBooking::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($builder) use ($search) {
                $builder->where('patient_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('package_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('booking_status')) {
            $query->where('booking_status', $request->booking_status);
        }

        $bookings = $query->orderByDesc('created_at')->paginate(15);

        $totals = [
            'total' => HealthPackageBooking::count(),
            'confirmed' => HealthPackageBooking::where('booking_status', 'confirmed')->count(),
            'paid' => HealthPackageBooking::where('payment_status', 'paid')->count(),
            'revenue' => HealthPackageBooking::where('payment_status', 'paid')->sum('package_price'),
        ];

        return view('admin.health-package-bookings.index', compact('bookings', 'totals'));
    }

    public function show(HealthPackageBooking $booking)
    {
        $booking->load('user');

        return view('admin.health-package-bookings.show', [
            'booking' => $booking,
        ]);
    }

    public function update(Request $request, HealthPackageBooking $booking)
    {
        $data = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
            'booking_status' => 'required|in:pending,confirmed,completed,cancelled',
            'admin_remarks' => 'nullable|string',
        ]);

        $booking->update($data);

        if ($booking->user_id) {
            \App\Models\Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Booking updated',
                'message' => "Your package booking #HP-{$booking->id} status updated to " . ucfirst($booking->booking_status),
                'type' => 'booking_status',
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'booking' => $booking]);
        }

        return back()->with('success', 'Health package booking updated successfully.');
    }

    public function updateReport(Request $request, HealthPackageBooking $booking)
    {
        $request->validate([
            'report_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($booking->report_file && Storage::disk('public')->exists($booking->report_file)) {
            Storage::disk('public')->delete($booking->report_file);
        }

        $path = $request->file('report_file')->store('booking-reports/health-packages', 'public');
        $booking->update([
            'report_file' => $path,
            'report_uploaded_at' => now(),
        ]);

        if ($booking->user_id) {
            \App\Models\Notification::create([
                'user_id' => $booking->user_id,
                'title' => 'Report uploaded',
                'message' => "Your health package booking #HP-{$booking->id} report is now available.",
                'type' => 'report',
            ]);
        }

        return back()->with('success', 'Health package report uploaded successfully.');
    }

    public function destroy(HealthPackageBooking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.health-package-bookings.index')
            ->with('success', 'Health package booking deleted.');
    }
}
