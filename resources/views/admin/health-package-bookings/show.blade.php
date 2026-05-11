@extends('admin.layouts.app')
@section('title', 'Booking Details')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Health Package Booking</h1>
            <p class="text-sm text-gray-500 mt-1">Booking #{{ $booking->id }}</p>
        </div>
        <a href="{{ route('admin.health-package-bookings.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card lg:col-span-2 space-y-6">
            <div>
                <h2 class="text-base font-semibold text-gray-900 mb-4">Patient Details</h2>
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-500">Patient</p><p class="font-medium text-gray-900">{{ $booking->patient_name }}</p></div>
                    <div><p class="text-gray-500">Phone</p><p class="font-medium text-gray-900">{{ $booking->phone }}</p></div>
                    <div><p class="text-gray-500">Email</p><p class="font-medium text-gray-900">{{ $booking->email }}</p></div>
                    <div><p class="text-gray-500">Gender / Age</p><p class="font-medium text-gray-900">{{ $booking->gender }} / {{ $booking->age }}</p></div>
                    <div class="sm:col-span-2"><p class="text-gray-500">Address</p><p class="font-medium text-gray-900">{{ $booking->address }}, {{ $booking->city }}, {{ $booking->state }} - {{ $booking->pincode }}</p></div>
                </div>
            </div>

            <div>
                <h2 class="text-base font-semibold text-gray-900 mb-4">Booking Details</h2>
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><p class="text-gray-500">Package</p><p class="font-medium text-gray-900">{{ $booking->package_name }}</p></div>
                    <div><p class="text-gray-500">Price</p><p class="font-medium text-gray-900">₹{{ number_format($booking->package_price, 2) }}</p></div>
                    <div><p class="text-gray-500">Preferred Date</p><p class="font-medium text-gray-900">{{ $booking->preferred_date?->format('M d, Y') }}</p></div>
                    <div><p class="text-gray-500">Preferred Slot</p><p class="font-medium text-gray-900">{{ $booking->preferred_time_slot }}</p></div>
                    <div><p class="text-gray-500">Payment Method</p><p class="font-medium text-gray-900">{{ ucfirst($booking->payment_method) }}</p></div>
                    <div><p class="text-gray-500">Transaction ID</p><p class="font-medium text-gray-900">{{ $booking->transaction_id ?: '—' }}</p></div>
                </div>
            </div>

            @if($booking->notes)
                <div>
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Notes</h2>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $booking->notes }}</p>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Status</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between"><span class="text-gray-500">Payment</span><span class="badge {{ $booking->payment_status === 'paid' ? 'badge-success' : ($booking->payment_status === 'failed' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($booking->payment_status) }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-gray-500">Booking</span><span class="badge {{ $booking->booking_status === 'confirmed' ? 'badge-info' : ($booking->booking_status === 'completed' ? 'badge-success' : ($booking->booking_status === 'cancelled' ? 'badge-danger' : 'badge-warning')) }}">{{ ucfirst($booking->booking_status) }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-gray-500">Booked At</span><span class="text-gray-900">{{ $booking->created_at->format('M d, Y h:i A') }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-gray-500">Updated</span><span class="text-gray-900">{{ $booking->updated_at->format('M d, Y h:i A') }}</span></div>
                </div>
            </div>

            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Source</h2>
                <p class="text-sm text-gray-600">{{ $booking->user?->name ? 'Registered user: ' . $booking->user->name : 'Guest booking' }}</p>
            </div>

            <form method="POST" action="{{ route('admin.health-package-bookings.destroy', $booking) }}" onsubmit="return confirm('Delete this booking? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger w-full">Delete Booking</button>
            </form>
        </div>
    </div>
@endsection
