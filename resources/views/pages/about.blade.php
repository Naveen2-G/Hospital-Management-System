@extends('layouts.page')
@section('title', 'About Us')
@section('meta_description', 'Learn about HMS Hospital — our mission, values, history, and commitment to quality healthcare.')
@section('page_title', 'About Us')
@section('page_subtitle', 'Dedicated to providing world-class healthcare with compassion and innovation')
@section('breadcrumb', 'About Us')

@section('content')
<!-- Mission & Vision -->
<section class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block px-4 py-1.5 bg-primary-50 text-primary-600 text-sm font-semibold rounded-full mb-4">Our Story</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-6">Transforming Healthcare Since 2010</h2>
                <p class="text-gray-600 leading-relaxed mb-4">HMS Hospital was founded with a singular vision — to make quality healthcare accessible, affordable, and patient-centered. Over the past decade, we have grown from a modest 50-bed facility to a comprehensive multi-specialty hospital serving over 10,000 patients annually.</p>
                <p class="text-gray-600 leading-relaxed mb-6">Our team of 200+ medical professionals, supported by cutting-edge technology and evidence-based practices, ensures every patient receives the highest standard of care.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-primary-50 rounded-2xl p-5 text-center">
                        <div class="text-3xl font-extrabold text-primary-600">14+</div>
                        <div class="text-sm text-gray-600 mt-1">Years of Excellence</div>
                    </div>
                    <div class="bg-emerald-50 rounded-2xl p-5 text-center">
                        <div class="text-3xl font-extrabold text-emerald-600">200+</div>
                        <div class="text-sm text-gray-600 mt-1">Expert Doctors</div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/10 to-emerald-500/10 rounded-3xl transform translate-x-4 translate-y-4"></div>
                <img src="{{ asset('images/hospital.png') }}" alt="Modern Hospital Building" class="relative rounded-3xl shadow-2xl object-cover w-full h-[450px] lg:h-[550px]">
                
                <!-- Floating Card -->
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-6 shadow-xl border border-gray-100 hidden sm:block">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Quality Standard</p>
                            <p class="font-bold text-gray-900">NABH Accredited</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-16 lg:py-24 bg-gradient-to-b from-gray-50 via-white to-gray-50 relative overflow-hidden">
    <div class="absolute inset-0 bg-cross-pattern"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-sm font-semibold rounded-full mb-4">What Drives Us</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">Our Core Values</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $values = [
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Compassion', 'desc' => 'We treat every patient with empathy, respect, and dignity, ensuring comfort throughout their healing journey.', 'color' => 'rose'],
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Integrity', 'desc' => 'We maintain the highest ethical standards in all our medical practices and patient interactions.', 'color' => 'blue'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Innovation', 'desc' => 'We leverage cutting-edge technology and evidence-based treatments to deliver the best patient outcomes.', 'color' => 'amber'],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Teamwork', 'desc' => 'Our multidisciplinary teams collaborate to provide coordinated, comprehensive care for every patient.', 'color' => 'emerald'],
            ]; @endphp
            @foreach($values as $val)
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 hover:shadow-xl hover:border-{{ $val['color'] }}-200 transition-all duration-300 hover:-translate-y-1">
                <div class="w-12 h-12 bg-{{ $val['color'] }}-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-{{ $val['color'] }}-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $val['icon'] }}"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $val['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Leadership Team -->
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-primary-50 text-primary-600 text-sm font-semibold rounded-full mb-4">Leadership</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">Our Leadership Team</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php $leaders = [
                ['name' => 'Dr. Vikram Mehta', 'role' => 'Chief Medical Officer', 'exp' => '25+ years in Hospital Administration'],
                ['name' => 'Dr. Sunita Rao', 'role' => 'Director of Nursing', 'exp' => '20+ years in Clinical Nursing'],
                ['name' => 'Mr. Arjun Kapoor', 'role' => 'CEO & Managing Director', 'exp' => '18+ years in Healthcare Management'],
            ]; @endphp
            @foreach($leaders as $leader)
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-20 h-20 bg-gradient-to-br from-primary-100 to-emerald-50 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg">{{ $leader['name'] }}</h3>
                <p class="text-primary-600 font-medium text-sm mt-1">{{ $leader['role'] }}</p>
                <p class="text-gray-500 text-sm mt-2">{{ $leader['exp'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
