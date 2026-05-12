@extends('admin.layouts.app')
@section('title', 'Lab Booking')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.lab-bookings.index') }}" class="btn btn-gray">&larr; Back to bookings</a>
    </div>

    <div class="admin-card">
        <h1 class="text-xl font-bold mb-4">Lab Booking #LB-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="font-semibold">Patient</h2>
                <p>{{ $booking->patient_name }}</p>
                <p class="text-sm text-gray-500">{{ $booking->phone }} · {{ $booking->email }}</p>

                <h2 class="font-semibold mt-4">Test</h2>
                <p>{{ $booking->test_name }} — ₹{{ number_format($booking->test_price, 2) }}</p>

                <h2 class="font-semibold mt-4">Schedule</h2>
                <p>{{ optional($booking->preferred_date)->format('d M, Y') }} · {{ $booking->preferred_time_slot }}</p>
            </div>

            <div>
                <h2 class="font-semibold">Status</h2>
                <p>Booking: {{ ucwords(str_replace('_', ' ', $booking->booking_status)) }}</p>
                <p>Payment: {{ ucfirst($booking->payment_status) }}</p>

                <h2 class="font-semibold mt-4">Admin remarks</h2>
                <p>{{ $booking->admin_remarks ?? '-' }}</p>
            </div>
        </div>
    </div>
@endsection
