@extends('layouts.page')
@section('title', 'Package Booking Successful')
@section('page_title', 'Booking Confirmed')
@section('page_subtitle', 'Your health package booking has been successfully placed.')
@section('breadcrumb', 'Success')

@section('content')
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">
        @if(!$booking)
            <div class="bg-white rounded-3xl shadow-xl p-12 text-center border border-gray-100">
                <div class="w-20 h-20 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Booking Not Found</h2>
                <p class="text-gray-500 mb-8">We couldn't find the details for this booking. If you just completed a payment, it might take a few minutes to process.</p>
                <a href="{{ route('health-packages') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-primary-600 text-white font-bold rounded-2xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                    Back to Packages
                </a>
            </div>
        @else
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 animate-fade-in-up">
            <!-- Header -->
            <div class="bg-primary-600 p-8 text-center text-white">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white/30">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 class="text-3xl font-extrabold">Thank You, {{ $booking->patient_name }}!</h2>
                <p class="text-primary-100 mt-2">Your booking ID is <span class="font-bold text-white">#HP-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span></p>
            </div>

            <!-- Details -->
            <div class="p-8 lg:p-12">
                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Left: Package Info -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6 border-b border-gray-100 pb-2">Package Information</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500">Selected Package</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->package_name }}</p>
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
                                <p class="text-xs text-gray-500">Payment Status</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $booking->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ strtoupper($booking->payment_status) }}
                                    </span>
                                    <span class="text-xs text-gray-500">via {{ ucfirst($booking->payment_method) }}</span>
                                </div>
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
                        <p class="text-sm text-gray-500">Total Package Amount</p>
                        <p class="text-3xl font-extrabold text-primary-600">₹{{ number_format($booking->package_price, 2) }}</p>
                    </div>
                    <div class="flex gap-4">
                        <button onclick="window.print()" class="flex items-center gap-2 px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Print Summary
                        </button>
                        <a href="{{ route('health-packages') }}" 
                           class="flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                            Browse More Packages
                        </a>
                    </div>
                </div>
            </div>

            <!-- Important Info -->
            <div class="bg-primary-50 p-6 border-t border-primary-100">
                <div class="flex gap-4">
                    <div class="w-10 h-10 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-primary-900">What's next?</p>
                        <p class="text-sm text-primary-700">Our medical team will contact you within 2 hours to confirm the phlebotomist's arrival time. Please ensure you are fasting for at least 8-10 hours before the sample collection.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
