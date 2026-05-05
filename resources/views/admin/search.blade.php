@extends('admin.layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Search Results</h1>
        <p class="text-slate-600">
            @if($q)
                Showing results for: <span class="font-semibold text-slate-900">"{{ $q }}"</span>
            @else
                Enter a search query to find patients, doctors, and appointments
            @endif
        </p>
    </div>

    {{-- Search Form --}}
    <div class="mb-8">
        <form action="{{ route('admin.search') }}" method="GET" class="flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Search patients, doctors, appointments..." class="flex-1 px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Search</button>
        </form>
    </div>

    @if($q)
        <div class="grid gap-8">
            {{-- Patients Results --}}
            @if($patients->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Patients ({{ $patients->count() }})
                    </h2>
                    <div class="space-y-3">
                        @foreach($patients as $patient)
                            <a href="{{ route('admin.patients.show', $patient->id) }}" class="block p-4 border border-slate-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-all">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $patient->name }}</p>
                                        <p class="text-sm text-slate-600">{{ $patient->email ?? 'N/A' }} • {{ $patient->phone ?? 'N/A' }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Doctors Results --}}
            @if($doctors->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Doctors ({{ $doctors->count() }})
                    </h2>
                    <div class="space-y-3">
                        @foreach($doctors as $doctor)
                            <a href="{{ route('admin.doctors.show', $doctor->id) }}" class="block p-4 border border-slate-200 rounded-lg hover:bg-green-50 hover:border-green-300 transition-all">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-900">Dr. {{ $doctor->name }}</p>
                                        <p class="text-sm text-slate-600">{{ $doctor->specialization ?? 'N/A' }} • {{ $doctor->email ?? 'N/A' }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Appointments Results --}}
            @if($appointments->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Appointments ({{ $appointments->count() }})
                    </h2>
                    <div class="space-y-3">
                        @foreach($appointments as $appointment)
                            <a href="{{ route('admin.appointments.show', $appointment->id) }}" class="block p-4 border border-slate-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 transition-all">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $appointment->patient->name ?? 'Unknown' }} with Dr. {{ $appointment->doctor->name ?? 'Unknown' }}</p>
                                        <p class="text-sm text-slate-600">{{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y • H:i A') : 'No date' }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- No Results --}}
            @if($patients->count() === 0 && $doctors->count() === 0 && $appointments->count() === 0)
                <div class="bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">No results found</h3>
                    <p class="text-slate-600">We couldn't find any matches for "<span class="font-medium">{{ $q }}</span>"</p>
                    <p class="text-sm text-slate-500 mt-2">Try searching with different keywords or terms</p>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-200 p-12 text-center shadow-sm">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Start searching</h3>
            <p class="text-slate-600">Use the search form above to find patients, doctors, and appointments</p>
        </div>
    @endif
@endsection
