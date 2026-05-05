@extends('layouts.page')
@section('title', 'Appointments')
@section('meta_description', 'Book appointments with top doctors at HMS Hospital. Easy scheduling, online consultations, and walk-in options.')
@section('page_title', 'Appointments')
@section('page_subtitle', 'Schedule your visit with our expert doctors quickly and easily')
@section('breadcrumb', 'Appointments')

@section('content')
<!-- How it Works -->
<section class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-primary-50 text-primary-600 text-sm font-semibold rounded-full mb-4">Simple Process</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">How to Book an Appointment</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $steps = [
                ['step'=>'01','title'=>'Choose Department','desc'=>'Select the medical department based on your health needs — Cardiology, Neurology, Pediatrics, and more.','color'=>'blue'],
                ['step'=>'02','title'=>'Select Doctor','desc'=>'Browse our qualified specialists, check their availability, experience, and patient ratings.','color'=>'emerald'],
                ['step'=>'03','title'=>'Pick Date & Time','desc'=>'Choose a convenient date and time slot. We offer morning, afternoon, and evening appointments.','color'=>'amber'],
                ['step'=>'04','title'=>'Confirm Booking','desc'=>'Review your appointment details and confirm. Receive instant confirmation via email and SMS.','color'=>'violet'],
            ]; @endphp
            @foreach($steps as $s)
            <div class="relative bg-white rounded-2xl p-7 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="text-4xl font-extrabold text-{{ $s['color'] }}-100 absolute top-4 right-5">{{ $s['step'] }}</div>
                <div class="w-12 h-12 bg-{{ $s['color'] }}-50 rounded-2xl flex items-center justify-center mb-5">
                    <span class="text-lg font-bold text-{{ $s['color'] }}-500">{{ $s['step'] }}</span>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $s['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $s['desc'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="grid lg:grid-cols-2 gap-12 items-center mt-16">
            <div class="relative order-2 lg:order-1">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/20 to-emerald-500/20 rounded-3xl transform -translate-x-4 translate-y-4"></div>
                <img src="{{ asset('images/consultation.png') }}" alt="Doctor Consultation" class="relative rounded-3xl shadow-xl object-cover w-full h-[350px] lg:h-[400px]">
            </div>
            <div class="order-1 lg:order-2">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Ready to Prioritize Your Health?</h3>
                <p class="text-gray-600 leading-relaxed mb-8">Our seamless booking system ensures you get the care you need precisely when you need it. Choose from in-person visits or secure online video consultations with our specialists.</p>
                <button data-open-modal="appointment-modal" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white font-bold rounded-xl shadow-lg shadow-primary-500/25 hover:shadow-xl hover:-translate-y-0.5 transition-all cursor-pointer">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Book Appointment Now
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Appointment Types -->
<section class="py-16 lg:py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-sm font-semibold rounded-full mb-4">Options</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Appointment Types</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @php $types = [
                ['title'=>'In-Person Visit','desc'=>'Visit our hospital for a face-to-face consultation with your doctor. Ideal for physical examinations, diagnostics, and follow-up visits.','icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4','features'=>['Walk-in or scheduled','Full diagnostic access','Insurance accepted']],
                ['title'=>'Online Consultation','desc'=>'Connect with our doctors from the comfort of your home via secure video call. Perfect for follow-ups, prescriptions, and non-emergency consultations.','icon'=>'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z','features'=>['Secure video calls','E-prescriptions','No travel needed']],
                ['title'=>'Emergency Care','desc'=>'Our 24/7 emergency department is equipped to handle critical and life-threatening situations with immediate medical attention.','icon'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z','features'=>['24/7 availability','Trauma specialists','ICU-equipped']],
            ]; @endphp
            @foreach($types as $t)
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-xl mb-3">{{ $t['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed mb-5">{{ $t['desc'] }}</p>
                <ul class="space-y-2">
                    @foreach($t['features'] as $f)
                    <li class="flex items-center gap-2 text-sm text-gray-700"><svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ $f }}</li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
