<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPackageBooking;
use Illuminate\Http\Request;

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
        ]);

        $booking->update($data);

        return back()->with('success', 'Health package booking updated successfully.');
    }

    public function destroy(HealthPackageBooking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.health-package-bookings.index')
            ->with('success', 'Health package booking deleted.');
    }
}
