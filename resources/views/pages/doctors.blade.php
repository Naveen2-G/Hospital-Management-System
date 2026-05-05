@extends('layouts.page')
@section('title', 'Our Doctors')
@section('meta_description', 'Meet our team of experienced and qualified doctors across multiple specialties at HMS Hospital.')
@section('page_title', 'Our Doctors')
@section('page_subtitle', 'Expert medical professionals committed to your health and well-being')
@section('breadcrumb', 'Our Doctors')

@section('content')
<section class="py-16 lg:py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-dot-pattern opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Input -->
        <div class="max-w-xl mx-auto mb-8">
            <div class="relative flex items-center bg-white border border-gray-200 rounded-2xl shadow-sm p-2 focus-within:ring-2 focus-within:ring-primary-500/20 focus-within:border-primary-400 transition-all">
                <svg class="absolute left-4 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="page-doctor-search" placeholder="Search by doctor name or specialty..." class="flex-1 pl-10 pr-4 py-2 text-sm text-gray-700 bg-transparent focus:outline-none" value="{{ request('q') }}">
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-12" id="doctor-filters">
            @foreach(['All','Cardiology','Dermatology','Neurology','Pediatrics','Orthopedics','General Medicine'] as $tab)
            <button data-filter="{{ $tab }}" class="filter-btn px-5 py-2.5 text-sm font-medium rounded-xl border transition-all {{ $loop->first ? 'bg-primary-500 text-white border-primary-500 shadow-md active-filter' : 'bg-white text-gray-600 border-gray-200 hover:border-primary-300 hover:text-primary-600' }}">{{ $tab }}</button>
            @endforeach
        </div>

        <!-- Doctors Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $doctors = [
                ['name'=>'Dr. Rajesh Sharma','spec'=>'Cardiology','exp'=>'15+ years','rating'=>'4.9','avail'=>'Mon-Fri','image'=> asset("images/doctor-coat-1.svg")],
                ['name'=>'Dr. Priya Patel','spec'=>'Dermatology','exp'=>'10+ years','rating'=>'4.8','avail'=>'Mon-Sat','image'=> asset("images/doctor-coat-2.svg")],
                ['name'=>'Dr. Anil Kumar','spec'=>'Neurology','exp'=>'20+ years','rating'=>'4.9','avail'=>'Tue-Sat','image'=> asset("images/doctor-coat-3.svg")],
                ['name'=>'Dr. Sneha Reddy','spec'=>'Pediatrics','exp'=>'8+ years','rating'=>'4.7','avail'=>'Mon-Fri','image'=> asset("images/doctor-coat-4.svg")],
                ['name'=>'Dr. Amit Verma','spec'=>'Orthopedics','exp'=>'18+ years','rating'=>'4.8','avail'=>'Mon-Sat','image'=> asset("images/doctor-coat-5.svg")],
                ['name'=>'Dr. Kavita Singh','spec'=>'General Medicine','exp'=>'12+ years','rating'=>'4.6','avail'=>'Mon-Fri','image'=> asset("images/doctor-coat-6.svg")],
                ['name'=>'Dr. Ravi Deshmukh','spec'=>'ENT Specialist','exp'=>'14+ years','rating'=>'4.7','avail'=>'Wed-Sun','image'=> asset("images/doctor-coat-7.svg")],
                ['name'=>'Dr. Meera Nair','spec'=>'Gynecology','exp'=>'16+ years','rating'=>'4.9','avail'=>'Mon-Fri','image'=> asset("images/doctor-coat-8.svg")],
            ]; @endphp
            @foreach($doctors as $doc)
            <div class="doctor-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group" data-department="{{ $doc['spec'] }}">
                <div class="h-64 relative bg-gray-100 overflow-hidden">
                    <img src="{{ $doc['image'] }}" alt="{{ $doc['name'] }}" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-emerald-100/90 backdrop-blur-sm text-emerald-700 text-xs font-semibold rounded-full z-10">Available</span>
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg">{{ $doc['name'] }}</h3>
                    <p class="text-primary-600 font-medium text-sm">{{ $doc['spec'] }}</p>
                    <div class="flex items-center justify-between mt-3 text-sm text-gray-500">
                        <span>{{ $doc['exp'] }} exp.</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>{{ $doc['rating'] }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $doc['avail'] }}</p>
                    <button data-open-modal="appointment-modal" data-department="{{ $doc['spec'] }}" data-doctor="{{ $doc['name'] }}" class="w-full mt-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 text-white text-sm font-semibold rounded-xl hover:from-primary-600 hover:to-primary-700 shadow-md shadow-primary-500/20 transition-all hover:shadow-lg hover:-translate-y-0.5 cursor-pointer">Book Now</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
