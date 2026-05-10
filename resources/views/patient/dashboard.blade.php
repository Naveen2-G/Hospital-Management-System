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
        </div>
        <img src="{{ asset('images/patient-blob.svg') }}" class="patient-hero-blob" alt="" />
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
                    <div class="apt-widget-none">No upcoming appointments.<br><small>Book one using the Appointments tab below.</small></div>
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

    <!-- Tabs -->
    <div class="mt-8">
        <div class="patient-tabs" data-tabs>
            <button class="patient-tab active" data-tab="appointments">Appointments</button>
            <button class="patient-tab" data-tab="reports">Reports</button>
            <button class="patient-tab" data-tab="prescriptions">Prescriptions</button>
            <button class="patient-tab" data-tab="invoices">Invoices</button>
            <button class="patient-tab" data-tab="profile">My Profile</button>
        </div>

        <!-- Appointments Panel -->
        <section class="mt-5 patient-card" data-tab-panel="appointments">
            <div class="patient-card-header">
                <h2 class="patient-card-title flex items-center gap-2">
                    <div class="card-title-icon bg-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    Appointments
                </h2>
                <p class="patient-card-subtitle">Your recent and upcoming visits.</p>
            </div>
            <!-- Booking Form -->
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <div class="text-sm font-extrabold text-slate-900">Book a doctor appointment</div>
                        <div class="mt-1 text-sm text-slate-600">This booking will appear in the respective doctor and admin dashboards.</div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ url('/appointments') }}" class="patient-pill">Need help choosing?</a>
                        <button type="button" class="patient-pill patient-pill-dark" data-apt-open>Book appointment</button>
                    </div>
                </div>
                <div class="mt-4 hidden" data-apt-panel>
                    <div class="mb-3 flex items-center justify-between gap-3">
                        <div class="text-xs font-bold uppercase tracking-[0.22em] text-slate-500">Appointment form</div>
                        <button type="button" class="patient-pill" data-apt-close>Close</button>
                    </div>
                    <form class="grid grid-cols-1 gap-3 md:grid-cols-2" method="POST" action="{{ route('patient.appointments.store') }}" data-appointment-booking>
                        @csrf
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Full name</label>
                            <input name="name" value="{{ old('name', $patient->name ?? $user->name) }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Age</label>
                                <input type="number" min="1" max="120" name="age" value="{{ old('age') }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-semibold text-slate-700">Gender</label>
                                <select name="gender" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                                    @php($genderOld = old('gender', $patient->gender ?? 'male'))
                                    <option value="male" {{ $genderOld === 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $genderOld === 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $genderOld === 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $patient->email ?? $user->email) }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Phone</label>
                            <input name="phone" value="{{ old('phone', $patient->phone ?? $user->phone) }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Department</label>
                            <select name="department_id" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" data-department required>
                                <option value="">Select department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Doctor</label>
                            <select name="doctor" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" data-doctor required>
                                <option value="">Select doctor</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}" data-dept="{{ $doc->department_id }}" {{ old('doctor') == $doc->id ? 'selected' : '' }}>{{ $doc->name }}{{ $doc->department ? ' · ' . $doc->department->name : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Appointment date</label>
                            <input type="date" name="appointment_date" value="{{ old('appointment_date', now()->toDateString()) }}" min="{{ now()->toDateString() }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Time slot</label>
                            <select name="time_slot" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                                @foreach(['09:00 - 09:30','09:30 - 10:00','10:00 - 10:30','10:30 - 11:00','11:00 - 11:30','11:30 - 12:00','14:00 - 14:30','14:30 - 15:00','15:00 - 15:30','15:30 - 16:00','16:00 - 16:30','16:30 - 17:00'] as $slot)
                                    <option value="{{ $slot }}" {{ old('time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Notes (optional)</label>
                            <textarea name="notes" rows="3" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" placeholder="Describe symptoms or reason for visit...">{{ old('notes') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-sm font-semibold text-slate-700">Appointment type</label>
                            <select name="appointment_type" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                                <option value="regular">In-Person Consultation</option>
                                <option value="video">Video Consultation</option>
                            </select>
                        </div>
                        <div class="md:col-span-2 flex flex-wrap items-center gap-3">
                            <button type="submit" class="patient-pill patient-pill-dark">Confirm booking</button>
                            <button type="button" class="patient-pill" data-apt-close>Cancel</button>
                            <div class="text-xs font-semibold text-slate-500">After booking, you’ll see it in the table below.</div>
                        </div>
                    </form>
                </div>
            </div>

            @if($appointments->isEmpty())
                <div class="patient-empty">No appointments found yet.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="patient-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $apt)
                            <tr>
                                <td>{{ optional($apt->appointment_date)->format('d M Y') }}</td>
                                <td>{{ $apt->time_slot }}</td>
                                <td>{{ $apt->doctor?->name ?? '—' }}</td>
                                <td>{{ $apt->department?->name ?? '—' }}</td>
                                <td class="capitalize">{{ $apt->type }}</td>
                                <td><span class="patient-badge badge-{{ $apt->status }}">{{ ucfirst($apt->status) }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <!-- Reports Panel -->
        <section class="mt-5 patient-card hidden" data-tab-panel="reports">
            <div class="patient-card-header">
                <h2 class="patient-card-title flex items-center gap-2">
                    <div class="card-title-icon bg-amber-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    Lab reports
                </h2>
                <p class="patient-card-subtitle">View completed lab results and reports.</p>
            </div>
            @if($labOrders->isEmpty())
                <div class="patient-empty">No lab orders found yet.</div>
            @else
                <div class="space-y-3">
                    @foreach($labOrders as $order)
                        <div class="patient-item">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <div class="font-semibold text-slate-900">{{ $order->labTest?->name ?? 'Lab test' }}</div>
                                    <span class="patient-badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                                </div>
                                <div class="mt-1 text-sm text-slate-600">Ordered {{ optional($order->ordered_at)->format('d M Y, h:i A') }} · Doctor: {{ $order->doctor?->name ?? '—' }}</div>
                            </div>
                            <div class="shrink-0">
                                @if($order->report_file)
                                    <a class="patient-pill" href="{{ route('lab-orders.report', $order) }}" target="_blank" rel="noopener">Open report</a>
                                @else
                                    <span class="text-sm font-semibold text-slate-400">Pending</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Prescriptions Panel -->
        <section class="mt-5 patient-card hidden" data-tab-panel="prescriptions">
            <div class="patient-card-header">
                <h2 class="patient-card-title flex items-center gap-2">
                    <div class="card-title-icon bg-violet-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    Prescriptions
                </h2>
                <p class="patient-card-subtitle">Medicines prescribed by doctors.</p>
            </div>
            @if($prescriptions->isEmpty())
                <div class="patient-empty">No prescriptions found yet.</div>
            @else
                <div class="space-y-4">
                    @foreach($prescriptions as $rx)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">Doctor: {{ $rx->doctor?->name ?? '—' }}
                                        @if($rx->appointment)
                                            <span class="text-slate-400">·</span> Appointment: {{ optional($rx->appointment->appointment_date)->format('d M Y') }}
                                        @endif
                                    </div>
                                    @if($rx->diagnosis)
                                        <div class="mt-1 text-sm text-slate-600">Diagnosis: {{ $rx->diagnosis }}</div>
                                    @endif
                                </div>
                                <div class="text-xs font-semibold text-slate-500">{{ $rx->created_at?->format('d M Y') }}</div>
                            </div>
                            @if($rx->items->isNotEmpty())
                                <div class="mt-4 overflow-x-auto">
                                    <table class="patient-table">
                                        <thead>
                                        <tr>
                                            <th>Medicine</th>
                                            <th>Dosage</th>
                                            <th>Frequency</th>
                                            <th>Duration</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rx->items as $item)
                                            <tr>
                                                <td>{{ $item->medicine?->name ?? '—' }}</td>
                                                <td>{{ $item->dosage ?? '—' }}</td>
                                                <td>{{ $item->frequency ?? '—' }}</td>
                                                <td>{{ $item->duration ?? '—' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            @if($rx->notes)
                                <div class="mt-3 text-sm text-slate-600"><span class="font-semibold text-slate-800">Notes:</span> {{ $rx->notes }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Invoices Panel -->
        <section class="mt-5 patient-card hidden" data-tab-panel="invoices">
            <div class="patient-card-header">
                <h2 class="patient-card-title flex items-center gap-2">
                    <div class="card-title-icon bg-rose-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z"/></svg>
                    </div>
                    Invoices
                </h2>
                <p class="patient-card-subtitle">Billing details and payment status.</p>
            </div>
            @if($invoices->isEmpty())
                <div class="patient-empty">No invoices found yet.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="patient-table">
                        <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $inv)
                            <tr>
                                <td>{{ $inv->invoice_number ?? ('#' . $inv->id) }}</td>
                                <td>₹{{ number_format((float) $inv->total_amount, 2) }}</td>
                                <td>₹{{ number_format((float) $inv->paid_amount, 2) }}</td>
                                <td>₹{{ number_format((float) $inv->due_amount, 2) }}</td>
                                <td><span class="patient-badge badge-{{ $inv->status }}">{{ ucfirst($inv->status) }}</span></td>
                                <td class="text-right">
                                    @if((float) $inv->due_amount > 0)
                                        <a href="{{ route('patient.invoices.payment.create', $inv) }}" class="patient-pill patient-pill-dark">Pay now</a>
                                    @else
                                        <span class="text-sm font-semibold text-emerald-700">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <!-- Profile Panel -->
        <section class="mt-5 patient-card hidden" data-tab-panel="profile">
            <div class="patient-card-header">
                <h2 class="patient-card-title flex items-center gap-2">
                    <div class="card-title-icon bg-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                    </div>
                    My Profile
                </h2>
                <p class="patient-card-subtitle">Update your personal and medical information.</p>
            </div>
            <form method="POST" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="profile-avatar-wrap">
                    @if(isset($patient->avatar) && $patient->avatar)
                        <img src="{{ asset('storage/'.$patient->avatar) }}" alt="Avatar" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">{{ strtoupper(substr($patient->name ?? 'P', 0, 1)) }}</div>
                    @endif
                    <div>
                        <div style="font-weight:800;font-size:0.95rem;color:#0f172a;">{{ $patient->name }}</div>
                        <div style="font-size:0.8rem;color:#64748b;margin-top:0.15rem;">{{ $user->email }}</div>
                        <label style="margin-top:0.6rem;display:inline-flex;align-items:center;gap:0.4rem;font-size:0.75rem;font-weight:700;color:#10b981;cursor:pointer;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                            Change Photo
                            <input type="file" name="avatar" accept="image/*" style="display:none;" onchange="this.parentNode.querySelector('span').textContent=this.files[0]?.name??''">
                            <span style="color:#94a3b8;font-weight:500;"></span>
                        </label>
                    </div>
                </div>

                <div class="profile-section-title">Personal Information</div>
                <div class="profile-field-group">
                    <div class="profile-field">
                        <label>Full Name *</label>
                        <input class="profile-input" type="text" name="name" value="{{ old('name', $patient->name) }}" required>
                    </div>
                    <div class="profile-field">
                        <label>Phone</label>
                        <input class="profile-input" type="text" name="phone" value="{{ old('phone', $patient->phone) }}">
                    </div>
                    <div class="profile-field">
                        <label>Date of Birth</label>
                        <input class="profile-input" type="date" name="dob" value="{{ old('dob', $patient->dob?->format('Y-m-d')) }}">
                    </div>
                    <div class="profile-field">
    <label>Gender</label>

    <select class="profile-input" name="gender">
        <option value="">Select</option>
        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
        <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
    </select>
</div>
                    <div class="profile-field" style="grid-column:1/-1">
                        <label>Address</label>
                        <textarea class="profile-input" name="address" rows="2">{{ old('address', $patient->address) }}</textarea>
                    </div>
                </div>

                <div class="profile-section-title">Medical Information</div>
                <div class="profile-field-group">
                    <div class="profile-field">
                        <label>Blood Group</label>
                        <select class="profile-input" name="blood_group">
                            <option value="">Select</option>
                            @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg_opt)
                                <option value="{{ $bg_opt }}" {{ old('blood_group', $patient->blood_group ?? '') === $bg_opt ? 'selected' : '' }}>{{ $bg_opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="profile-field">
                        <label>Allergies</label>
                        <input class="profile-input" type="text" name="allergies" value="{{ old('allergies', $patient->allergies ?? '') }}" placeholder="e.g. Penicillin, Dust">
                    </div>
                    <div class="profile-field" style="grid-column:1/-1">
                        <label>Chronic Diseases</label>
                        <input class="profile-input" type="text" name="chronic_diseases" value="{{ old('chronic_diseases', $patient->chronic_diseases ?? '') }}" placeholder="e.g. Diabetes, Hypertension">
                    </div>
                </div>

                <div class="profile-section-title">Emergency Contact</div>
                <div class="profile-field-group">
                    <div class="profile-field">
                        <label>Contact Name</label>
                        <input class="profile-input" type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" placeholder="e.g. Rahul Kumar">
                    </div>
                    <div class="profile-field">
                        <label>Contact Phone</label>
                        <input class="profile-input" type="text" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}" placeholder="e.g. +91 98765 43210">
                    </div>
                </div>

                <div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <button type="submit" class="patient-pill patient-pill-dark">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Save Profile
                    </button>
                    <a href="{{ route('patient.change-password.edit') }}" class="patient-pill">
                        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                        Change Password
                    </a>
                </div>
            </form>
        </section>
    </div>

    <script>
        const urlTab = new URLSearchParams(window.location.search).get('tab');
        if (urlTab) {
            const targetBtn = document.querySelector('[data-tab="'+urlTab+'"]');
            if (targetBtn) targetBtn.click();
        }
    </script>
@endsection

