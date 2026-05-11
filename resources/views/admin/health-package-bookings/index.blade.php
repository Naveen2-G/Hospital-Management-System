@extends('admin.layouts.app')
@section('title', 'Health Package Bookings')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Health Package Bookings</h1>
            <p class="text-sm text-gray-500 mt-1">Track preventive check-up bookings submitted by patients.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="kpi-card">
            <div class="kpi-icon bg-blue-50">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5V6a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 004.5 6v12A2.25 2.25 0 006.75 20.25h10.5A2.25 2.25 0 0019.5 18V8.25M18 7.5h-3.75A1.5 1.5 0 0112.75 6V4.25"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($totals['total']) }}</p>
                <p class="kpi-label">Total Bookings</p>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon bg-emerald-50">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($totals['confirmed']) }}</p>
                <p class="kpi-label">Confirmed</p>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon bg-amber-50">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($totals['paid']) }}</p>
                <p class="kpi-label">Paid</p>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon bg-rose-50">
                <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33"/></svg>
            </div>
            <div>
                <p class="kpi-value">₹{{ number_format($totals['revenue']) }}</p>
                <p class="kpi-label">Paid Revenue</p>
            </div>
        </div>
    </div>

    <div class="admin-card mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="relative flex-1 min-w-55">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by patient, phone, email, or package..." class="form-input pl-10">
            </div>
            <select name="payment_status" class="form-input w-auto" onchange="this.form.submit()">
                <option value="">All Payment Status</option>
                @foreach(['pending', 'paid', 'failed'] as $status)
                    <option value="{{ $status }}" {{ request('payment_status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <select name="booking_status" class="form-input w-auto" onchange="this.form.submit()">
                <option value="">All Booking Status</option>
                @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" {{ request('booking_status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            @if(request()->hasAny(['search', 'payment_status', 'booking_status']))
                <a href="{{ route('admin.health-package-bookings.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        @if($bookings->isEmpty())
            <div class="empty-state py-16">
                <p class="text-sm">No health package bookings found.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="pl-6">Patient</th>
                            <th>Package</th>
                            <th>Schedule</th>
                            <th>Payment</th>
                            <th>Booking</th>
                            <th class="pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td class="pl-6">
                                    <div class="font-medium text-gray-900">{{ $booking->patient_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->phone }} · {{ $booking->email }}</div>
                                </td>
                                <td>
                                    <div class="font-medium text-gray-900">{{ $booking->package_name }}</div>
                                    <div class="text-xs text-gray-500">₹{{ number_format($booking->package_price, 2) }}</div>
                                </td>
                                <td>
                                    <div class="text-sm text-gray-900">{{ $booking->preferred_date?->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->preferred_time_slot }}</div>
                                </td>
                                <td>
                                    <span class="badge {{ $booking->payment_status === 'paid' ? 'badge-success' : ($booking->payment_status === 'failed' ? 'badge-danger' : 'badge-warning') }}">{{ ucfirst($booking->payment_status) }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $booking->booking_status === 'confirmed' ? 'badge-info' : ($booking->booking_status === 'completed' ? 'badge-success' : ($booking->booking_status === 'cancelled' ? 'badge-danger' : 'badge-warning')) }}">{{ ucfirst($booking->booking_status) }}</span>
                                </td>
                                <td class="pr-6 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button
                                            type="button"
                                            data-update-url="{{ route('admin.health-package-bookings.update', $booking) }}"
                                            data-patient-name="{{ $booking->patient_name }}"
                                            data-package-name="{{ $booking->package_name }}"
                                            data-preferred-date="{{ $booking->preferred_date?->format('M d, Y') }}"
                                            data-payment-status="{{ $booking->payment_status }}"
                                            data-booking-status="{{ $booking->booking_status }}"
                                            onclick="openEditBookingModal(this)"
                                            class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600 transition-colors"
                                            title="Edit status"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L7.5 20.25 3 21l.75-4.5L16.862 4.487z"/></svg>
                                        </button>
                                        <a href="{{ route('admin.health-package-bookings.show', $booking) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.health-package-bookings.destroy', $booking) }}" class="inline" onsubmit="return confirm('Delete this booking? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

    <div id="editBookingModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeEditBookingModal()"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Update Booking</h2>
                    <button type="button" onclick="closeEditBookingModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="updateBookingForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div id="bookingInfo" class="p-4 bg-gray-50 rounded-xl space-y-2 text-sm text-gray-700">
                        </div>

                        <div>
                            <label class="form-label">Booking Status</label>
                            <select name="booking_status" id="modal_booking_status" class="form-input">
                                @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" id="modal_payment_status" class="form-input">
                                @foreach(['pending', 'paid', 'failed'] as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button type="button" onclick="closeEditBookingModal()" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditBookingModal(button) {
            document.getElementById('updateBookingForm').action = button.dataset.updateUrl;
            document.getElementById('modal_booking_status').value = button.dataset.bookingStatus;
            document.getElementById('modal_payment_status').value = button.dataset.paymentStatus;
            document.getElementById('bookingInfo').innerHTML = `
                <p><span class="font-semibold text-gray-900">Patient:</span> ${button.dataset.patientName}</p>
                <p><span class="font-semibold text-gray-900">Package:</span> ${button.dataset.packageName}</p>
                <p><span class="font-semibold text-gray-900">Schedule:</span> ${button.dataset.preferredDate || '—'}</p>
            `;

            document.getElementById('editBookingModal').classList.remove('hidden');
        }

        function closeEditBookingModal() {
            document.getElementById('editBookingModal').classList.add('hidden');
        }
    </script>
@endsection
