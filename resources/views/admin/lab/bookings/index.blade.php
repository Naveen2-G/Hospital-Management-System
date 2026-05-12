@extends('admin.layouts.app')
@section('title', 'Lab Bookings')
@section('content')

    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn-back mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                Back to Dashboard
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Lab Test Bookings</h1>
            <p class="text-sm text-gray-500 mt-1">Manage public lab test requests and payments</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or phone..." class="form-input pl-10 input-with-icon">
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
                    <th class="pl-6">Patient</th>
                    <th>Test Name</th>
                    <th>Schedule</th>
                    <th>Payment</th>
                    <th>Booking</th>
                    <th class="pr-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50/50" data-booking-id="{{ $booking->id }}">
                    <td class="pl-6">
                        <div class="font-medium text-gray-900">{{ $booking->patient_name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->phone }} · {{ $booking->email }}</div>
                        @if(!$booking->user_id)
                            <span class="inline-block text-[10px] text-amber-600 font-bold uppercase mt-0.5">Guest User</span>
                        @endif
                    </td>
                    <td>
                        <div class="font-medium text-gray-900">{{ $booking->test_name }}</div>
                        <div class="text-xs text-gray-500">₹{{ number_format($booking->test_price, 2) }}</div>
                    </td>
                    <td>
                        <div class="text-sm text-gray-900">{{ $booking->preferred_date?->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->preferred_time_slot }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $booking->payment_status === 'paid' ? 'badge-success' : ($booking->payment_status === 'failed' ? 'badge-danger' : ($booking->payment_status === 'refunded' ? 'badge-gray' : 'badge-warning')) }}">{{ ucfirst($booking->payment_status) }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $booking->booking_status === 'confirmed' ? 'badge-info' : ($booking->booking_status === 'sample_collected' ? 'badge-primary' : ($booking->booking_status === 'completed' ? 'badge-success' : ($booking->booking_status === 'cancelled' ? 'badge-danger' : 'badge-warning'))) }}">{{ ucwords(str_replace('_', ' ', $booking->booking_status)) }}</span>
                    </td>
                    <td class="pr-6 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <button
                                type="button"
                                data-upload-url="{{ route('admin.lab-bookings.report.update', $booking) }}"
                                data-booking-title="{{ $booking->patient_name }}"
                                data-booking-subtitle="{{ $booking->test_name }} · {{ $booking->preferred_date->format('d M, Y') }}"
                                data-current-report-url="{{ $booking->report_file ? route('admin.lab-bookings.report', $booking) : '' }}"
                                data-current-report-name="{{ $booking->report_file ? basename($booking->report_file) : '' }}"
                                onclick="openReportUploadModal(this)"
                                class="p-1.5 rounded-lg hover:bg-sky-50 text-gray-400 hover:text-sky-600 transition-colors"
                                title="Upload report"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-8m0 0-3 3m3-3 3 3M4.5 12a7.5 7.5 0 1 1 15 0 7.5 7.5 0 0 1-15 0Z"/></svg>
                            </button>
                            <button
                                type="button"
                                data-update-url="{{ route('admin.lab-bookings.update', $booking) }}"
                                data-patient-name="{{ $booking->patient_name }}"
                                data-test-name="{{ $booking->test_name }}"
                                data-test-price="{{ $booking->test_price }}"
                                data-preferred-date="{{ $booking->preferred_date?->format('M d, Y') }}"
                                data-payment-status="{{ $booking->payment_status }}"
                                data-booking-status="{{ $booking->booking_status }}"
                                data-admin-remarks="{{ $booking->admin_remarks }}"
                                onclick="openEditBookingModal(this)"
                                class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600 transition-colors"
                                title="Edit status"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.25 2.25 0 113.182 3.182L7.5 20.25 3 21l.75-4.5L16.862 4.487z"/></svg>
                            </button>
                            <a href="{{ route('admin.lab-bookings.show', $booking) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.lab-bookings.destroy', $booking) }}" class="inline" onsubmit="return confirm('Delete this booking? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
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

                <form id="updateBookingForm" method="POST" onsubmit="handleBookingFormSubmit(event)">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div id="bookingInfo" class="p-4 bg-gray-50 rounded-xl space-y-2 text-sm text-gray-700">
                        </div>

                        <div>
                            <label class="form-label">Booking Status</label>
                            <select name="booking_status" id="modal_booking_status" class="form-input">
                                @foreach(['pending', 'confirmed', 'sample_collected', 'completed', 'cancelled'] as $status)
                                    <option value="{{ $status }}">{{ ucwords(str_replace('_', ' ', $status)) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Payment Status</label>
                            <select name="payment_status" id="modal_payment_status" class="form-input">
                                @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Admin Remarks</label>
                            <textarea name="admin_remarks" id="modal_admin_remarks" class="form-input" rows="3" placeholder="Optional remarks for the patient (visible in patient portal)"></textarea>
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

    <div id="reportUploadModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-8">
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeReportUploadModal()"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Upload Lab Report</h2>
                    <button type="button" onclick="closeReportUploadModal()" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                <form id="reportUploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="p-4 bg-gray-50 rounded-xl space-y-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lab Booking</p>
                            <p id="reportBookingTitle" class="text-sm font-semibold text-gray-900"></p>
                            <p id="reportBookingSubtitle" class="text-xs text-gray-500"></p>
                        </div>

                        <div id="currentReportWrap" class="hidden rounded-xl border border-sky-100 bg-sky-50 p-4">
                            <p class="text-xs font-bold uppercase tracking-wider text-sky-700 mb-2">Current report</p>
                            <a id="currentReportLink" href="#" target="_blank" class="text-sm font-semibold text-sky-700 hover:text-sky-800"></a>
                        </div>

                        <div>
                            <label class="form-label">Report File</label>
                            <input type="file" name="report_file" class="form-input @error('report_file') border-red-500 @enderror" accept=".pdf,.jpg,.jpeg,.png" required>
                            @error('report_file')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-400">PDF, JPG, JPEG, or PNG up to 5MB.</p>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <button type="button" onclick="closeReportUploadModal()" class="btn btn-secondary">Cancel</button>
                            <button type="submit" id="reportSubmitBtn" class="btn btn-primary">Upload Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function handleBookingFormSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('updateBookingForm');
            const submitBtn = event.target.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(form))
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response;
            })
            .then(() => {
                console.log('Update successful, reloading page...');
                setTimeout(() => location.reload(), 500);
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Error saving booking: ' + err.message);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Save Changes';
            });
        }

        function openEditBookingModal(button) {
            document.getElementById('updateBookingForm').action = button.dataset.updateUrl;
            document.getElementById('modal_booking_status').value = button.dataset.bookingStatus;
            document.getElementById('modal_payment_status').value = button.dataset.paymentStatus;
            document.getElementById('bookingInfo').innerHTML = `
                <p><span class="font-semibold text-gray-900">Patient:</span> ${button.dataset.patientName}</p>
                <p><span class="font-semibold text-gray-900">Test:</span> ${button.dataset.testName}</p>
                <p><span class="font-semibold text-gray-900">Schedule:</span> ${button.dataset.preferredDate || '—'}</p>
            `;

            // populate admin remarks if present
            const remarks = button.dataset.adminRemarks || '';
            const remarksEl = document.getElementById('modal_admin_remarks');
            if (remarksEl) remarksEl.value = remarks;

            document.getElementById('editBookingModal').classList.remove('hidden');
        }

        function closeEditBookingModal() {
            document.getElementById('editBookingModal').classList.add('hidden');
        }

        function openReportUploadModal(button) {
            const form = document.getElementById('reportUploadForm');
            const currentReportWrap = document.getElementById('currentReportWrap');
            const currentReportLink = document.getElementById('currentReportLink');

            form.action = button.dataset.uploadUrl;
            document.getElementById('reportBookingTitle').textContent = button.dataset.bookingTitle || '';
            document.getElementById('reportBookingSubtitle').textContent = button.dataset.bookingSubtitle || '';

            if (button.dataset.currentReportUrl) {
                currentReportLink.href = button.dataset.currentReportUrl;
                currentReportLink.textContent = button.dataset.currentReportName || 'View current report';
                currentReportWrap.classList.remove('hidden');
            } else {
                currentReportWrap.classList.add('hidden');
                currentReportLink.removeAttribute('href');
                currentReportLink.textContent = '';
            }

            document.getElementById('reportUploadModal').classList.remove('hidden');
        }

        function closeReportUploadModal() {
            document.getElementById('reportUploadModal').classList.add('hidden');
        }

        document.getElementById('reportUploadForm').onsubmit = function() {
            const btn = document.getElementById('reportSubmitBtn');
            btn.disabled = true;
            btn.textContent = 'Uploading...';
        };
    </script>
@endsection
