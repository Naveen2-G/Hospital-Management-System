@extends('layouts.page')
@section('title', 'Booking Successful')
@section('page_title', 'Booking Confirmed')
@section('page_subtitle', 'Your lab test booking has been successfully placed.')
@section('breadcrumb', 'Success')

@section('content')
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-emerald-500 p-8 text-center text-white">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 class="text-3xl font-extrabold">Thank You, {{ $booking->patient_name }}!</h2>
                <p class="text-emerald-100 mt-2">Your booking ID is <span class="font-bold text-white">#LB-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span></p>
            </div>

            <!-- Details -->
            <div class="p-8 lg:p-12">
                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Left: Test Info -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-100 pb-2">Test Information</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500">Selected Test</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->test_name }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Preferred Date</p>
                                    <p class="font-semibold text-gray-900">{{ $booking->preferred_date->format('d M, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Time Slot</p>
                                    <p class="font-semibold text-gray-900">{{ $booking->preferred_time_slot }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Payment Method</p>
                                <p class="font-semibold text-gray-900 capitalize">{{ $booking->payment_method }} ({{ $booking->payment_status }})</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Patient Info -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-100 pb-2">Patient & Address</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500">Contact Number</p>
                                <p class="font-semibold text-gray-900">{{ $booking->phone }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Collection Address</p>
                                <p class="font-semibold text-gray-900 leading-relaxed">
                                    {{ $booking->address }},<br>
                                    {{ $booking->city }}, {{ $booking->state }} - {{ $booking->pincode }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="text-center sm:text-left">
                        <p class="text-sm text-gray-500">Total Amount Paid/Due</p>
                        <p class="text-3xl font-extrabold text-primary-600">₹{{ number_format($booking->test_price, 2) }}</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('lab-bookings.receipt', $booking->id) }}" target="_blank" 
                           class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Print Confirmation
                        </a>
                        <a href="{{ route('lab-tests') }}" 
                           class="flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                            Back to Lab Tests
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Message -->
            <div class="bg-gray-50 p-6 text-center border-t border-gray-100">
                <p class="text-sm text-gray-500">A confirmation email has been sent to <span class="font-semibold text-gray-700">{{ $booking->email }}</span></p>
            </div>
        </div>
    </div>
</section>
@endsection
