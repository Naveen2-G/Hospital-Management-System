@extends('layouts.page')
@section('title', $service['title'])
@section('meta_description', $service['meta'])
@section('page_title', $service['title'])
@section('page_subtitle', $service['subtitle'])
@section('breadcrumb', $service['title'])

@section('content')
<!-- Overview -->
<section class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-12 rounded-3xl overflow-hidden shadow-2xl relative">
            <img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }} Department" class="w-full h-[300px] lg:h-[400px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
        </div>
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <div>
                <span class="inline-block px-4 py-1.5 bg-{{ $service['color'] }}-50 text-{{ $service['color'] }}-600 text-sm font-semibold rounded-full mb-4">{{ $service['badge'] }}</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-6">{{ $service['heading'] }}</h2>
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-600 leading-relaxed mb-4">{{ $service['description'] }}</p>
                    <p class="text-gray-600 leading-relaxed">{{ $service['description2'] }}</p>
                </div>
                <div class="mt-8">
                    <button data-open-modal="appointment-modal" data-department="{{ $service['title'] }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-{{ $service['color'] }}-500 to-{{ $service['color'] }}-600 text-white font-semibold rounded-xl shadow-lg shadow-{{ $service['color'] }}-500/25 hover:shadow-xl hover:-translate-y-0.5 transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Book Appointment
                    </button>
                </div>
            </div>
            <!-- Key Info Cards -->
            <div class="space-y-5">
                @foreach($service['info_cards'] as $card)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-{{ $service['color'] }}-50 rounded-2xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-{{ $service['color'] }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $card['title'] }}</h3>
                            <p class="text-sm text-gray-600 mt-0.5">{{ $card['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Treatments / Procedures -->
<section class="py-16 lg:py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-sm font-semibold rounded-full mb-4">What We Treat</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Conditions & Treatments</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($service['treatments'] as $t)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-{{ $service['color'] }}-200 transition-all duration-300 hover:-translate-y-0.5 flex items-center gap-4">
                <div class="w-10 h-10 bg-{{ $service['color'] }}-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-{{ $service['color'] }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <span class="font-medium text-gray-800">{{ $t }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Doctors in this department -->
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-primary-50 text-primary-600 text-sm font-semibold rounded-full mb-4">Our Specialists</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Meet Our {{ $service['title'] }} Doctors</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($service['doctors'] as $doc)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                <div class="h-64 relative bg-gray-100 overflow-hidden">
                    <img src="{{ $doc['image'] }}" alt="{{ $doc['name'] }}" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 text-lg">{{ $doc['name'] }}</h3>
                    <p class="text-{{ $service['color'] }}-600 font-medium text-sm">{{ $doc['qualification'] }}</p>
                    <p class="text-gray-500 text-sm mt-1">{{ $doc['exp'] }} experience</p>
                    <button data-open-modal="appointment-modal" data-department="{{ $service['title'] }}" data-doctor="{{ $doc['name'] }}" class="w-full mt-4 py-2.5 bg-gradient-to-r from-{{ $service['color'] }}-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:shadow-lg transition-all hover:-translate-y-0.5 cursor-pointer">Book Appointment</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
