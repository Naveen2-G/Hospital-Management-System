@extends('layouts.page')
@section('title', 'Health Packages')
@section('meta_description', 'Explore comprehensive health check-up packages at HMS Hospital — preventive care for individuals and families.')
@section('page_title', 'Health Packages')
@section('page_subtitle', 'Comprehensive preventive health check-up packages for every stage of life')
@section('breadcrumb', 'Health Packages')

@section('content')
<section class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Health Banner -->
        <div class="relative rounded-3xl overflow-hidden shadow-2xl mb-16 flex flex-col lg:flex-row bg-gradient-to-br from-primary-600 to-emerald-600">
            <div class="p-8 lg:p-12 lg:w-1/2 flex flex-col justify-center text-white z-10">
                <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold rounded-full mb-4 inline-block self-start backdrop-blur-sm">Preventive Care</span>
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Invest in Your Family's Health</h2>
                <p class="text-primary-100 text-lg leading-relaxed mb-8">Regular health check-ups can identify early signs of health issues before they become serious. Prevention is always better than cure.</p>
                <button data-open-modal="appointment-modal" class="self-start px-8 py-3.5 bg-white text-primary-600 font-bold rounded-xl hover:bg-gray-50 transition-colors cursor-pointer shadow-lg hover:-translate-y-0.5">Book a Check-up</button>
            </div>
            <div class="lg:w-1/2 h-[300px] lg:h-auto relative">
                <img src="{{ asset('images/health.png') }}" alt="Healthy Family" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-l from-primary-600/90 via-primary-600/40 to-transparent"></div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php $packages = [
                ['name'=>'Basic Health Check','price'=>'₹1,999','tests'=>'35+ tests','badge'=>'','color'=>'blue','includes'=>['Complete Blood Count','Lipid Profile','Blood Sugar (Fasting)','Liver Function Test','Kidney Function Test','Urine Analysis','BMI Assessment','Doctor Consultation']],
                ['name'=>'Comprehensive Health Check','price'=>'₹4,999','tests'=>'65+ tests','badge'=>'Most Popular','color'=>'emerald','includes'=>['Everything in Basic','Thyroid Panel (T3, T4, TSH)','Vitamin D & B12','HbA1c','Chest X-Ray','ECG','Cardiac Risk Markers','Dietician Consultation']],
                ['name'=>'Executive Health Check','price'=>'₹9,999','tests'=>'90+ tests','badge'=>'Premium','color'=>'violet','includes'=>['Everything in Comprehensive','Cardiac Stress Test','Ultrasound Abdomen','Pulmonary Function Test','Cancer Markers','Bone Density Scan','Eye & Dental Check','Specialist Consultations (3)']],
            ]; @endphp
            @foreach($packages as $pkg)
            <div class="bg-white rounded-3xl shadow-sm border-2 {{ $pkg['badge'] ? 'border-'.$pkg['color'].'-400 ring-4 ring-'.$pkg['color'].'-50' : 'border-gray-100' }} overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex flex-col relative">
                @if($pkg['badge'])
                <div class="absolute top-5 right-5 px-3 py-1 bg-{{ $pkg['color'] }}-500 text-white text-xs font-bold rounded-full">{{ $pkg['badge'] }}</div>
                @endif
                <div class="p-8 flex-1">
                    <h3 class="text-xl font-bold text-gray-900">{{ $pkg['name'] }}</h3>
                    <div class="mt-4 flex items-end gap-1">
                        <span class="text-4xl font-extrabold text-gray-900">{{ $pkg['price'] }}</span>
                        <span class="text-sm text-gray-500 mb-1">/ package</span>
                    </div>
                    <p class="text-sm text-{{ $pkg['color'] }}-600 font-medium mt-2">{{ $pkg['tests'] }} included</p>
                    <div class="h-px bg-gray-100 my-6"></div>
                    <ul class="space-y-3">
                        @foreach($pkg['includes'] as $item)
                        <li class="flex items-center gap-2.5 text-sm text-gray-700">
                            <svg class="w-4 h-4 text-{{ $pkg['color'] }}-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ $item }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="p-8 pt-0">
                    <button data-open-modal="package-checkout-modal" data-pkg-name="{{ $pkg['name'] }}" data-pkg-price="{{ str_replace(['₹', ','], '', $pkg['price']) }}" data-pkg-display-price="{{ $pkg['price'] }}" data-pkg-badge="{{ $pkg['badge'] ?: 'Standard' }}" class="w-full py-3.5 {{ $pkg['badge'] ? 'bg-gradient-to-r from-'.$pkg['color'].'-500 to-'.$pkg['color'].'-600 text-white shadow-lg shadow-'.$pkg['color'].'-500/20' : 'border-2 border-gray-200 text-gray-700 hover:bg-gray-50' }} font-semibold rounded-xl transition-all hover:shadow-xl hover:-translate-y-0.5 cursor-pointer package-book-btn">Book Package</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
