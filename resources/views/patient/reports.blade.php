@extends('patient.layouts.app')

@section('title', 'Reports')

@section('content')
    <section class="patient-card">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-amber-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                </div>
                Lab reports
            </h2>
            <p class="patient-card-subtitle">View completed lab results and reports.</p>
        </div>

        @if($labOrders->isEmpty())
            <div class="patient-empty">No lab orders found yet.</div>
        @else
            <div class="space-y-3">
                @foreach($labOrders as $order)
                    <div class="patient-item" style="align-items:flex-start;">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="font-semibold text-slate-900">{{ $order->labTest?->name ?? 'Lab test' }}</div>
                                <span class="patient-badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="mt-1 text-sm text-slate-600">
                                Ordered {{ optional($order->ordered_at)->format('d M Y, h:i A') }}
                                <span class="text-slate-400">·</span>
                                Doctor: {{ $order->doctor?->name ?? '—' }}
                                @if($order->completed_at)
                                    <span class="text-slate-400">·</span>
                                    Completed {{ optional($order->completed_at)->format('d M Y, h:i A') }}
                                @endif
                            </div>

                            @if($order->result)
                                <div class="mt-2 text-sm text-slate-600">
                                    <span class="font-semibold text-slate-800">Details:</span>
                                    {{ \Illuminate\Support\Str::limit($order->result, 280) }}
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0">
                            @if($order->report_file)
                                <a class="patient-pill" href="{{ route('lab-orders.report', $order) }}" target="_blank" rel="noopener">Open lab report</a>
                            @else
                                <span class="text-sm font-semibold text-slate-400">Pending</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="patient-card mt-6">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-amber-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                </div>
                Lab booking reports
            </h2>
            <p class="patient-card-subtitle">View reports uploaded from your lab bookings.</p>
                <a class="patient-pill" href="{{ route('lab-tests') }}">Book lab test</a>
        </div>

        @if($labBookings->isEmpty())
            <div class="patient-empty">No lab bookings found yet.</div>
        @else
            <div class="space-y-3">
                @foreach($labBookings as $booking)
                    <div class="patient-item" style="align-items:flex-start;">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="font-semibold text-slate-900">{{ $booking->test_name }}</div>
                                <span class="patient-badge badge-{{ $booking->booking_status === 'completed' ? 'completed' : $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
                            </div>
                            <div class="mt-1 text-sm text-slate-600">
                                Booking ID: <strong>#LB-{{ str_pad($booking->id,6,'0',STR_PAD_LEFT) }}</strong>
                                <span class="text-slate-400">·</span>
                                Booked {{ optional($booking->created_at)->format('d M Y, h:i A') }}
                                <span class="text-slate-400">·</span>
                                Date: {{ optional($booking->preferred_date)->format('d M Y') }}
                                <div class="mt-1">Payment: <strong>{{ ucfirst($booking->payment_status ?? 'pending') }}</strong></div>
                                @if(!empty($booking->admin_remarks))
                                    <div class="mt-2 p-3 bg-gray-50 rounded text-sm text-gray-700">Admin: {{ $booking->admin_remarks }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="shrink-0 flex items-center gap-2">
                            @if($booking->report_file)
                                <a class="patient-pill" href="{{ route('lab-bookings.report.patient', ['booking' => $booking, 'download' => 0]) }}" target="_blank" rel="noopener">View report</a>
                                <a class="patient-pill" href="{{ route('lab-bookings.report.patient', ['booking' => $booking, 'download' => 1]) }}">Download PDF</a>
                            @else
                                <span class="text-sm font-semibold text-slate-400">Report pending</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="patient-card mt-6">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5V6a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 004.5 6v12A2.25 2.25 0 006.75 20.25h10.5A2.25 2.25 0 0019.5 18V8.25M18 7.5h-3.75A1.5 1.5 0 0112.75 6V4.25"/></svg>
                </div>
                Health package reports
            </h2>
            <p class="patient-card-subtitle">View reports for completed health package bookings.</p>
                <a class="patient-pill" href="{{ route('health-packages') }}">Book package</a>
        </div>

        @if($healthPackageBookings->isEmpty())
            <div class="patient-empty">No health package bookings found yet.</div>
        @else
            <div class="space-y-3">
                @foreach($healthPackageBookings as $booking)
                    <div class="patient-item" style="align-items:flex-start;">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="font-semibold text-slate-900">{{ $booking->package_name }}</div>
                                    <span class="patient-badge badge-{{ $booking->booking_status === 'completed' ? 'completed' : $booking->booking_status }}">{{ ucfirst($booking->booking_status) }}</span>
                                </div>
                                <div class="mt-1 text-sm text-slate-600">
                                    Booking ID: <strong>#HP-{{ str_pad($booking->id,6,'0',STR_PAD_LEFT) }}</strong>
                                    <span class="text-slate-400">·</span>
                                    Booked {{ optional($booking->created_at)->format('d M Y, h:i A') }}
                                    <span class="text-slate-400">·</span>
                                    Date: {{ optional($booking->preferred_date)->format('d M Y') }}
                                    <div class="mt-1">Payment: <strong>{{ ucfirst($booking->payment_status ?? 'pending') }}</strong></div>
                                    @if(!empty($booking->admin_remarks))
                                        <div class="mt-2 p-3 bg-gray-50 rounded text-sm text-gray-700">Admin: {{ $booking->admin_remarks }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                @if($booking->report_file)
                                    <a class="patient-pill" href="{{ route('health-package-bookings.report', ['booking' => $booking, 'download' => 0]) }}" target="_blank" rel="noopener">View report</a>
                                    <a class="patient-pill" href="{{ route('health-package-bookings.report', ['booking' => $booking, 'download' => 1]) }}">Download PDF</a>
                                @else
                                    <span class="text-sm font-semibold text-slate-400">Report pending</span>
                                @endif
                            </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

@endsection
