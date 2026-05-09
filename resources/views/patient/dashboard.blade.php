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

    <!-- Tabs -->
    <div class="mt-8">
        <div class="patient-tabs" data-tabs>
            <button class="patient-tab active" data-tab="appointments">Appointments</button>
            <button class="patient-tab" data-tab="reports">Reports</button>
            <button class="patient-tab" data-tab="prescriptions">Prescriptions</button>
            <button class="patient-tab" data-tab="invoices">Invoices</button>
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
    </div>
@endsection
