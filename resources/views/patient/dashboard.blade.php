<!-- Updated Patient Dashboard -->
@extends('patient.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Hero Banner -->
    <div class="patient-hero mb-8">
        <div class="patient-hero-content">
            <p class="patient-hero-badge medical-history-badge flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Medical history
            </p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white">Welcome, {{ $user->name }}</h1>
            <p class="mt-2 max-w-2xl text-sm text-emerald-100">
                View your appointments, lab reports, prescriptions, and invoices — updated from the admin and doctor dashboards.
            </p>

            {{-- Mobile / small screens avatar --}}
            <div class="mt-5 flex items-center gap-3 md:hidden">
                <div class="flex h-[200px] w-[200px] items-center justify-center overflow-hidden rounded-2xl border border-white/15 bg-white/10 shadow-lg shadow-emerald-950/25">
                    @if(!empty($patient->avatar))
                        <img
                            src="{{ Storage::url($patient->avatar) }}"
                            alt="Patient photo"
                            class="h-full w-full object-cover"
                            loading="lazy"
                        >
                    @else
                        <div class="text-xl font-extrabold tracking-tight text-white/90">
                            {{ strtoupper(substr($patient->name ?? $user->name ?? 'P', 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="text-sm font-semibold text-emerald-100/90">Patient profile</div>
            </div>
        </div>
        <div class="absolute right-6 top-1/2 hidden -translate-y-1/2 items-center gap-4 md:flex">
            <div class="flex h-50 w-50 items-center justify-center overflow-hidden rounded-full border border-white/15 bg-white/10 shadow-2xl shadow-emerald-950/35">
                @if(!empty($patient->avatar))
                    <img
                        src="{{ Storage::url($patient->avatar) }}"
                        alt="Patient photo"
                        class="h-full w-full object-cover"
                        loading="lazy"
                    >
                @else
                    <div class="text-3xl font-extrabold tracking-tight text-white/90">
                        {{ strtoupper(substr($patient->name ?? $user->name ?? 'P', 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="patient-stats-grid mb-8">
        <div class="patient-stat stat-emerald">
            <div class="stat-icon mb-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="patient-stat-label">Appointments</div>
            <div class="patient-stat-value">{{ $appointments->count() }}</div>
        </div>
        <div class="patient-stat stat-amber">
            <div class="stat-icon mb-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div class="patient-stat-label">Lab reports</div>
            <div class="patient-stat-value">{{ $labOrders->whereNotNull('report_file')->count() }}</div>
        </div>
        <div class="patient-stat stat-violet">
            <div class="stat-icon mb-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="patient-stat-label">Prescriptions</div>
            <div class="patient-stat-value">{{ $prescriptions->count() }}</div>
        </div>
        <div class="patient-stat stat-rose">
            <div class="stat-icon mb-2">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z"/></svg>
            </div>
            <div class="patient-stat-label">Outstanding due</div>
            <div class="patient-stat-value">₹{{ number_format((float) $invoices->sum('due_amount'), 2) }}</div>
        </div>
    </div>

    @php
        $now = now();
        $nextApt = $appointments->filter(fn($a) => $a->appointment_date >= $now->toDateString() && in_array($a->status,['pending','confirmed']))->sortBy('appointment_date')->first();
        $age = $patient->dob ? $patient->dob->age : null;
    @endphp

    <!-- Widget Grid -->
    <div class="patient-grid-2col">
        <div class="patient-grid-left">
            <!-- Upcoming Appointment -->
            <div class="apt-widget">
                <div class="apt-widget-label">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Next Appointment
                </div>
                @if($nextApt)
                    <div class="apt-widget-doctor">{{ $nextApt->doctor?->name ?? 'Doctor TBD' }}</div>
                    <div class="apt-widget-dept">{{ $nextApt->department?->name ?? 'General' }}</div>
                    <div class="apt-widget-meta">
                        <span class="apt-widget-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25"/></svg>
                            {{ optional($nextApt->appointment_date)->format('d M Y') }}
                        </span>
                        <span class="apt-widget-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $nextApt->time_slot }}
                        </span>
                        <span class="apt-widget-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            {{ ucfirst($nextApt->type ?? 'In-Person') }}
                        </span>
                        <span class="apt-widget-status {{ $nextApt->status }}">● {{ ucfirst($nextApt->status) }}</span>
                    </div>
                    @if($nextApt->doctor)
                    <div class="doctor-detail-card" style="margin-top:1rem;background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.15);">
                        <div class="doctor-avatar">{{ strtoupper(substr($nextApt->doctor->name,0,1)) }}</div>
                        <div class="doctor-info">
                            <p style="color:#fff;">{{ $nextApt->doctor->name }}</p>
                            <span style="color:#a7f3d0;">{{ $nextApt->doctor->specialization ?? $nextApt->department?->name ?? 'Specialist' }}{{ $nextApt->doctor->experience_years ? ' · '.$nextApt->doctor->experience_years.' yrs exp' : '' }}</span>
                        </div>
                    </div>
                    @endif
                @else
                    <div class="apt-widget-none">
                        No upcoming appointments.<br>
                        <small>Book one from <a href="{{ route('patient.appointments') }}" class="underline decoration-white/50 underline-offset-4">Appointments</a>.</small>
                    </div>
                @endif
            </div>

            <!-- Activity Timeline -->
            <div class="timeline-card">
                <div class="timeline-title">
                    <div class="timeline-title-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                    Recent Activity
                </div>
                @php
                    $activities = collect();
                    foreach($appointments->take(3) as $a) $activities->push(['color'=>'blue','icon'=>'📅','text'=>'Appointment '.ucfirst($a->status).' — Dr. '.($a->doctor?->name ?? '—'),'time'=>optional($a->created_at)->format('d M, h:i A')]);
                    foreach($labOrders->whereNotNull('report_file')->take(2) as $l) $activities->push(['color'=>'green','icon'=>'🧪','text'=>'Lab report ready: '.($l->labTest?->name ?? 'Lab test'),'time'=>optional($l->ordered_at)->format('d M, h:i A')]);
                    foreach($prescriptions->take(2) as $r) $activities->push(['color'=>'violet','icon'=>'💊','text'=>'Prescription from Dr. '.($r->doctor?->name ?? '—'),'time'=>optional($r->created_at)->format('d M, h:i A')]);
                    foreach($invoices->where('status','paid')->take(1) as $i) $activities->push(['color'=>'amber','icon'=>'✅','text'=>'Invoice paid: '.($i->invoice_number ?? '#'.$i->id),'time'=>optional($i->updated_at)->format('d M, h:i A')]);
                    $activities = $activities->sortByDesc('time')->take(6)->values();
                @endphp
                @if($activities->isEmpty())
                    <div class="patient-empty">No activity yet.</div>
                @else
                <div class="timeline-list">
                    @foreach($activities as $act)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $act['color'] }}">{{ $act['icon'] }}</div>
                        <div class="timeline-content">
                            <p>{{ $act['text'] }}</p>
                            <span>{{ $act['time'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="patient-grid-right">
            <!-- Health Summary -->
            <div class="health-card">
                <div class="health-card-title">
                    <div class="health-card-title-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg></div>
                    Health Summary
                </div>
                <div class="health-row">
                    <span class="health-label">Blood Group</span>
                    <span class="health-value blood">{{ $patient->blood_group ?? '—' }}</span>
                </div>
                <div class="health-row">
                    <span class="health-label">Age</span>
                    <span class="health-value">{{ $age ? $age.' years' : ($patient->dob ? $patient->dob->format('d M Y') : '—') }}</span>
                </div>
                <div class="health-row">
                    <span class="health-label">Gender</span>
                    <span class="health-value">{{ $patient->gender ? ucfirst($patient->gender) : '—' }}</span>
                </div>
                <div class="health-row">
                    <span class="health-label">Allergies</span>
                    <span class="health-value {{ $patient->allergies ? '' : 'na' }}">{{ $patient->allergies ?? 'None recorded' }}</span>
                </div>
                <div class="health-row">
                    <span class="health-label">Chronic Diseases</span>
                    <span class="health-value {{ $patient->chronic_diseases ? '' : 'na' }}">{{ $patient->chronic_diseases ?? 'None recorded' }}</span>
                </div>
                <div class="health-row">
                    <span class="health-label">Emergency Contact</span>
                    <span class="health-value">{{ $patient->emergency_contact_name ? $patient->emergency_contact_name.' · ' : '' }}{{ $patient->emergency_contact ?? '—' }}</span>
                </div>
                <div class="health-row">
                    <span class="health-label">Address</span>
                    <span class="health-value {{ $patient->address ? '' : 'na' }}" style="max-width:180px;word-break:break-word;">{{ $patient->address ?? 'Not provided' }}</span>
                </div>
            </div>

            <!-- Download Center -->
            <div class="download-card">
                <div class="download-card-title">
                    <div class="download-card-title-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg></div>
                    Download Center
                </div>
                @foreach($labOrders->whereNotNull('report_file')->take(3) as $lo)
                <div class="download-item">
                    <div class="download-item-icon" style="background:linear-gradient(135deg,#f59e0b,#d97706)"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg></div>
                    <div class="download-item-info"><p>{{ $lo->labTest?->name ?? 'Lab Report' }}</p><span>{{ optional($lo->ordered_at)->format('d M Y') }}</span></div>
                    <a href="{{ route('lab-orders.report', $lo) }}" target="_blank" class="download-btn"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>Download</a>
                </div>
                @endforeach
                @foreach($invoices->take(2) as $inv)
                <div class="download-item">
                    <div class="download-item-icon" style="background:linear-gradient(135deg,#f43f5e,#e11d48)"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg></div>
                    <div class="download-item-info"><p>Invoice {{ $inv->invoice_number ?? '#'.$inv->id }}</p><span>₹{{ number_format((float)$inv->total_amount,2) }} · {{ ucfirst($inv->status) }}</span></div>
                    <button onclick="window.print()" class="download-btn"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"/></svg>Print</button>
                </div>
                @endforeach
                @if($labOrders->whereNotNull('report_file')->isEmpty() && $invoices->isEmpty())
                <div class="patient-empty">No files available for download yet.</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Access -->
    <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('patient.appointments') }}" class="patient-card hover:shadow-lg transition">
            <div class="patient-card-header" style="border-bottom:0;margin-bottom:0;padding-bottom:0;">
                <h2 class="patient-card-title">
                    <span class="card-title-icon bg-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                    Appointments
                </h2>
                <p class="patient-card-subtitle">Book and view your visits.</p>
            </div>
        </a>
        <a href="{{ route('patient.reports') }}" class="patient-card hover:shadow-lg transition">
            <div class="patient-card-header" style="border-bottom:0;margin-bottom:0;padding-bottom:0;">
                <h2 class="patient-card-title">
                    <span class="card-title-icon bg-amber-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                    </span>
                    Reports
                </h2>
                <p class="patient-card-subtitle">Lab orders and downloadable reports.</p>
            </div>
        </a>
        <a href="{{ route('patient.prescriptions') }}" class="patient-card hover:shadow-lg transition">
            <div class="patient-card-header" style="border-bottom:0;margin-bottom:0;padding-bottom:0;">
                <h2 class="patient-card-title">
                    <span class="card-title-icon bg-violet-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                    </span>
                    Prescriptions
                </h2>
                <p class="patient-card-subtitle">Doctor issued medications and notes.</p>
            </div>
        </a>
        <a href="{{ route('patient.invoices') }}" class="patient-card hover:shadow-lg transition">
            <div class="patient-card-header" style="border-bottom:0;margin-bottom:0;padding-bottom:0;">
                <h2 class="patient-card-title">
                    <span class="card-title-icon bg-rose-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z"/></svg>
                    </span>
                    Invoices
                </h2>
                <p class="patient-card-subtitle">Billing details and payments.</p>
            </div>
        </a>
        <a href="{{ route('patient.profile') }}" class="patient-card hover:shadow-lg transition">
            <div class="patient-card-header" style="border-bottom:0;margin-bottom:0;padding-bottom:0;">
                <h2 class="patient-card-title">
                    <span class="card-title-icon bg-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </span>
                    Profile
                </h2>
                <p class="patient-card-subtitle">Personal and medical details.</p>
            </div>
        </a>
    </div>
@endsection

