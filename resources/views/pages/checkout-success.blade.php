@extends('layouts.page')
@section('title', 'Payment Successful')
@section('meta_description', 'Your payment was successful.')
@section('page_title', 'Payment Successful')
@section('page_subtitle', 'Thank you for choosing HMS Hospital')
@section('breadcrumb', 'Success')

@section('content')
<section class="py-16 lg:py-24 relative overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-lg mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-12 animate-fade-in-up">
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h2>
            <p class="text-gray-500 mb-8 leading-relaxed">Your health package booking has been confirmed. A receipt and further instructions have been sent to your email.</p>
            
            <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8 border border-gray-100">
                <div class="flex items-center gap-3 text-emerald-600 font-medium mb-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Transaction Complete</span>
                </div>
                <p class="text-sm text-gray-600">Session ID: <span class="font-mono text-xs text-gray-400 break-all">{{ request('session_id') ?? 'N/A' }}</span></p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('health-packages') }}" class="px-6 py-3 border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all text-center">Back to Packages</a>
                <a href="/" class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-lg shadow-primary-500/20 transition-all hover:-translate-y-0.5 text-center">Go to Home</a>
            </div>
        </div>

    </div>
</section>
@endsection
