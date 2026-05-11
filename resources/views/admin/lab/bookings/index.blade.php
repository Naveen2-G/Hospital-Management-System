@extends('admin.layouts.app')
@section('title', 'Lab Bookings')
@section('content')
    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Lab Test Bookings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage public lab test requests and payments</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or phone..." class="form-input pl-10">
            </div>
            <select name="payment_status" class="form-input">
                <option value="">All Payment Status</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
            <select name="booking_status" class="form-input">
                <option value="">All Booking Status</option>
                <option value="pending" {{ request('booking_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('booking_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="sample_collected" {{ request('booking_status') == 'sample_collected' ? 'selected' : '' }}>Sample Collected</option>
                <option value="completed" {{ request('booking_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('booking_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="btn btn-secondary flex-1">Filter</button>
                <a href="{{ route('admin.lab-bookings.index') }}" class="btn btn-gray">Reset</a>
            </div>
        </form>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="pl-6">Booking ID</th>
                    <th>Patient Details</th>
                    <th>Test & Price</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th class="pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50/50">
                    <td class="pl-6">
                        <span class="text-xs font-bold text-gray-400">#LB-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                        @if(!$booking->user_id)
                            <span class="block text-[10px] text-amber-600 font-bold uppercase mt-0.5">Guest User</span>
                        @endif
                    </td>
                    <td>
                        <div class="font-medium text-gray-900">{{ $booking->patient_name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->phone }}</div>
                        <div class="text-xs text-gray-400">{{ $booking->email }}</div>
                    </td>
                    <td>
                        <div class="font-medium text-gray-800">{{ $booking->test_name }}</div>
                        <div class="text-xs font-bold text-primary-600">₹{{ number_format($booking->test_price, 2) }}</div>
                    </td>
                    <td>
                        <div class="text-sm text-gray-900">{{ $booking->preferred_date->format('d M, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->preferred_time_slot }}</div>
                    </td>
                    <td>
                        @php
                            $ps = [
                                'pending' => 'badge-warning',
                                'paid' => 'badge-success',
                                'failed' => 'badge-danger',
                                'refunded' => 'badge-gray'
                            ];
                            $bs = [
                                'pending' => 'badge-warning',
                                'confirmed' => 'badge-info',
                                'sample_collected' => 'badge-primary',
                                'completed' => 'badge-success',
                                'cancelled' => 'badge-danger'
                            ];
                        @endphp
                        <div class="flex flex-col gap-1">
                            <span class="badge {{ $bs[$booking->booking_status] ?? 'badge-gray' }} self-start">
                                {{ ucwords(str_replace('_', ' ', $booking->booking_status)) }}
                            </span>
                            <span class="badge {{ $ps[$booking->payment_status] ?? 'badge-gray' }} self-start text-[10px] px-1.5 py-0">
                                Payment: {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                    </td>
                    <td class="pr-6 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="openEditModal({{ json_encode($booking) }})" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <form action="{{ route('admin.lab-bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Delete this booking?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-12 text-center text-gray-500">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($bookings->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $bookings->links() }}</div>
        @endif
    </div>

    <!-- Edit Modal -->
    <div id="editBookingModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeEditModal()"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Update Booking</h2>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                <form id="updateBookingForm" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="space-y-6">
                        <div id="booking_info" class="p-4 bg-gray-50 rounded-xl space-y-2">
                            <!-- JS will fill this -->
                        </div>

                        <div>
                            <label class="form-label">Booking Status</label>
                            <select name="booking_status" id="modal_booking_status" class="form-input">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="sample_collected">Sample Collected</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" id="modal_payment_status" class="form-input">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-full py-3">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(booking) {
            const form = document.getElementById('updateBookingForm');
            form.action = `/admin/lab-bookings/${booking.id}`;
            
            document.getElementById('modal_booking_status').value = booking.booking_status;
            document.getElementById('modal_payment_status').value = booking.payment_status;
            
            document.getElementById('booking_info').innerHTML = `
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Patient Details</p>
                <p class="text-sm font-semibold text-gray-900">${booking.patient_name}</p>
                <p class="text-xs text-gray-500">${booking.address}, ${booking.city}</p>
                <p class="text-xs text-gray-500">Test: ${booking.test_name} (₹${booking.test_price})</p>
                <p class="text-xs text-gray-500 font-bold">Method: ${booking.payment_method.toUpperCase()}</p>
            `;
            
            document.getElementById('editBookingModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editBookingModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
