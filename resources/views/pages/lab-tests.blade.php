@extends('layouts.page')
@section('title', 'Lab Tests')
@section('meta_description', 'Book lab tests at HMS Hospital — comprehensive diagnostics, home sample collection, and quick digital reports.')
@section('page_title', 'Lab Tests & Diagnostics')
@section('page_subtitle', 'Accurate diagnostics with state-of-the-art equipment and quick turnaround')
@section('breadcrumb', 'Lab Tests')

@section('content')
<section class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Lab Image Banner -->
        <div class="relative rounded-3xl overflow-hidden shadow-2xl mb-16">
            <img src="{{ asset('images/lab.png') }}" alt="Modern Lab Equipment" class="w-full h-[300px] lg:h-[400px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 to-transparent flex items-center">
                <div class="p-8 lg:p-12 max-w-2xl">
                    <span class="px-3 py-1 bg-primary-500 text-white text-xs font-bold rounded-full mb-4 inline-block">NABL Accredited</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Precision You Can Trust</h2>
                    <p class="text-gray-200 text-lg leading-relaxed">Our advanced laboratories are equipped with the latest technology to ensure accurate and timely diagnostic results.</p>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="grid sm:grid-cols-3 gap-6 mb-16">
            @php $features = [
                ['title'=>'NABL Accredited Lab','desc'=>'Our laboratory is accredited by the National Accreditation Board, ensuring the highest quality standards.','icon'=>'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['title'=>'Home Sample Collection','desc'=>'Get your samples collected from the comfort of your home by trained phlebotomists at no extra charge.','icon'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['title'=>'Digital Reports in 24hrs','desc'=>'Receive your test reports digitally within 24 hours. Access them anytime from your patient portal.','icon'=>'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ]; @endphp
            @foreach($features as $f)
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/></svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $f['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Tests List -->
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-600 text-sm font-semibold rounded-full mb-4">Popular Tests</span>
            <h2 class="text-3xl font-bold text-gray-900">Frequently Booked Lab Tests</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php $tests = [
                ['name'=>'Complete Blood Count (CBC)','price'=>'₹399','time'=>'6 hrs','params'=>'24 parameters'],
                ['name'=>'Lipid Profile','price'=>'₹599','time'=>'12 hrs','params'=>'8 parameters'],
                ['name'=>'Thyroid Panel (T3, T4, TSH)','price'=>'₹799','time'=>'24 hrs','params'=>'3 parameters'],
                ['name'=>'Liver Function Test (LFT)','price'=>'₹649','time'=>'12 hrs','params'=>'12 parameters'],
                ['name'=>'Kidney Function Test (KFT)','price'=>'₹549','time'=>'12 hrs','params'=>'7 parameters'],
                ['name'=>'HbA1c (Diabetes Screening)','price'=>'₹499','time'=>'24 hrs','params'=>'1 parameter'],
                ['name'=>'Vitamin D & B12','price'=>'₹1,199','time'=>'24 hrs','params'=>'2 parameters'],
                ['name'=>'Complete Urine Analysis','price'=>'₹249','time'=>'6 hrs','params'=>'15 parameters'],
                ['name'=>'COVID-19 RT-PCR','price'=>'₹499','time'=>'24 hrs','params'=>'1 parameter'],
            ]; @endphp
            @foreach($tests as $t)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg hover:border-primary-200 transition-all duration-300 flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900">{{ $t['name'] }}</h3>
                    <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-500">
                        <span>{{ $t['params'] }}</span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span>Report in {{ $t['time'] }}</span>
                    </div>
                </div>
                <div class="text-right shrink-0">
                    <div class="text-lg font-bold text-primary-600">{{ $t['price'] }}</div>
                    <button data-open-modal="labBookingModal" 
                            data-test-name="{{ $t['name'] }}" 
                            data-test-price="{{ $t['price'] }}"
                            class="mt-1 px-4 py-1.5 text-xs font-semibold text-primary-600 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors cursor-pointer">
                        Book Test
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
