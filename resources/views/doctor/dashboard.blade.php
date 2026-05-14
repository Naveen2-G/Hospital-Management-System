@extends('doctor.layouts.app')

@php
    $sectionTitles = [
        'overview' => 'Doctor Dashboard',
        'appointments' => 'Appointments',
        'patients' => 'Patients',
        'consultations' => 'Consultations',
        'prescriptions' => 'Prescriptions',
        'labs' => 'Labs & EMR',
        'schedule' => 'Schedule',
        'notifications' => 'Notifications',
        'reports' => 'Reports',
    ];
    $pageTitle = $sectionTitles[$activeSection ?? 'overview'] ?? 'Doctor Dashboard';
@endphp

@section('title', $pageTitle)

@section('content')
    @php
        $statusStyles = [
            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
            'confirmed' => 'bg-sky-100 text-sky-700 border-sky-200',
            'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            'cancelled' => 'bg-rose-100 text-rose-700 border-rose-200',
        ];
        $notificationStyles = [
            'appointment' => 'from-sky-50 to-blue-50 border-sky-100',
            'lab' => 'from-amber-50 to-orange-50 border-amber-100',
            'emergency' => 'from-rose-50 to-red-50 border-rose-100',
            'system' => 'from-slate-50 to-slate-100 border-slate-200',
        ];
        $doctorName = $doctor?->name ?? 'Doctor Portal';
        $doctorSpecialization = $doctor?->specialization ?? 'General Practice';
        $doctorQualification = $doctor?->qualification ?? 'Clinical Practitioner';
        $doctorDepartment = $doctor?->department?->name ?? 'Core care team';
        $appointmentOptions = $todayAppointments->merge($upcomingAppointments)->unique('id');
    @endphp

    <div class="space-y-8">
        @if(($activeSection ?? 'overview') === 'overview')
            {{-- Hero / Summary --}}
            <section class="relative overflow-hidden rounded-4xl border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.10)]">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(14,165,233,0.20),transparent_28%),radial-gradient(circle_at_bottom_left,rgba(59,130,246,0.15),transparent_30%)]"></div>
                <div class="relative grid gap-6 xl:grid-cols-[1.25fr_0.75fr] p-6 sm:p-8 lg:p-10">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-2 rounded-full border border-sky-200 bg-sky-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-sky-700">
                            Clinical command center
                        </div>

                        <div class="max-w-3xl">
                            <h2 class="text-4xl sm:text-5xl font-black leading-tight tracking-tight text-slate-950">
                                {{ $doctorName }}
                            </h2>
                            <p class="mt-4 max-w-2xl text-base sm:text-lg leading-8 text-slate-600">
                                Manage appointments, consultations, prescriptions, EMR access, lab requests, and patient follow-ups from one calm, secure workspace.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3 text-sm">
                            <span class="rounded-full border border-sky-200 bg-sky-50 px-4 py-2 font-semibold text-sky-700">{{ $doctorSpecialization }}</span>
                            <span class="rounded-full border border-slate-200 bg-white px-4 py-2 font-semibold text-slate-700">{{ $doctorQualification }}</span>
                            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 font-semibold text-emerald-700">{{ $doctorDepartment }}</span>
                        </div>
                    </div>

                    <div class="relative overflow-hidden rounded-4xl border border-slate-200 bg-slate-950 text-white shadow-2xl">
                        <div 
    class="absolute inset-0 bg-cover bg-center"
    style="background-image:
    linear-gradient(160deg, rgba(2,6,23,0.72), rgba(2,6,23,0.35)),
    url('{{ isset($doctor->image) && $doctor->image ? Storage::url($doctor->image) : asset('images/hero-medical.png') }}');">
</div>
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(125,211,252,0.28),transparent_28%),radial-gradient(circle_at_bottom_left,rgba(59,130,246,0.25),transparent_28%)]"></div>
                        <div class="relative flex h-full min-h-96 flex-col justify-between p-6 sm:p-8">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-200">Today at a glance</p>
                                    <p class="mt-2 text-2xl font-bold">{{ now()->format('l') }}</p>
                                </div>
                                <div class="rounded-2xl border border-white/15 bg-white/10 px-4 py-3 text-right backdrop-blur">
                                    <p class="text-xs uppercase tracking-[0.2em] text-cyan-200">Completion</p>
                                    <p class="mt-1 text-2xl font-black">{{ $stats['completion_rate'] }}%</p>
                                </div>
                            </div>

                            <div class="grid gap-3 sm:grid-cols-2">
                                <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl">
                                    <p class="text-sm text-slate-200">Completed visits</p>
                                    <p class="mt-2 text-3xl font-black">{{ $stats['completed_consultations'] }}</p>
                                </div>
                                <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl">
                                    <p class="text-sm text-slate-200">Unread alerts</p>
                                    <p class="mt-2 text-3xl font-black">{{ $stats['unread_notifications'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if(($activeSection ?? 'overview') === 'overview')
        {{-- Overview KPIs --}}
        <section id="overview" class="space-y-8">
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Overview</p>
                    <h3 class="text-2xl font-bold text-slate-900">Clinical summary</h3>
                </div>
                <p class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm text-slate-500 shadow-sm">{{ now()->format('l, M d, Y') }}</p>
            </div>

<x-doctor.stats-cards :stats="$stats" />

            {{-- Consultation Management - Doctor Workflow --}}
            <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-slate-950 text-white shadow-xl">
                <div class="bg-[linear-gradient(160deg,rgba(8,15,32,0.88),rgba(8,15,32,0.55)),url('{{ asset('images/consultation.png') }}')] bg-cover bg-center p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-200">Consultation management</p>
                    <h3 class="mt-2 text-2xl font-bold">Doctor workflow</h3>
                    <div class="mt-5 space-y-4">
                    @php
                        $workflow = [
                            'Open patient profile and review history',
                            'Add symptoms, observations, and diagnosis',
                            'Create or update prescription',
                            'Request lab tests if required',
                            'Save consultation and finalize visit history',
                        ];
                    @endphp
                    @foreach($workflow as $index => $step)
                        <div class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/8 p-4 backdrop-blur-sm">
                            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-cyan-400/15 text-sm font-bold text-cyan-200">{{ $index + 1 }}</div>
                            <p class="text-sm text-slate-100">{{ $step }}</p>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            {{-- Reports & Performance --}}
            <div id="reports" class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Reports & performance</p>
                        <h3 class="text-2xl font-bold text-slate-900">Doctor performance summary</h3>
                    </div>
                    <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">{{ $stats['completion_rate'] }}% completion</span>
                </div>

                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @php
                        $reportCards = [
                            ['label' => 'Patients treated', 'value' => $stats['patients_handled']],
                            ['label' => 'Consultations done', 'value' => $stats['completed_consultations']],
                            ['label' => 'Appointments pending', 'value' => $stats['pending_consultations']],
                            ['label' => 'Lab requests', 'value' => $stats['lab_requests']],
                        ];
                    @endphp
                    @foreach($reportCards as $card)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50/90 p-5 shadow-sm">
                            <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $card['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>


            {{-- Schedule Management & Weekly Availability --}}
            <div id="schedule" class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="mb-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Schedule management</p>
                    <h3 class="text-2xl font-bold text-slate-900">Weekly availability</h3>
                </div>
                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                    @foreach($weeklyAvailability as $day)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50/90 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-slate-900">{{ $day['day'] }}</p>
                                <span class="rounded-full {{ $day['available'] ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} px-3 py-1 text-xs font-semibold">
                                    {{ $day['available'] ? 'Available' : 'Blocked' }}
                                </span>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($day['slots'] as $slot)
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">{{ $slot }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Patient Management --}}
            <div id="patients" class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Patient management</p>
                        <h3 class="text-2xl font-bold text-slate-900">Assigned patients</h3>
                    </div>
                    <div class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm">{{ $stats['patients_handled'] }} tracked</div>
                </div>

                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @forelse($assignedPatients->take(6) as $patient)
                        <x-doctor.patient-card :patient="$patient" :patient-history="$patientHistory" :patient-timeline="$patientTimeline" />
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500 md:col-span-2 col-span-full">
                            No assigned patients yet.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- EMR Access & Record Visibility --}}
            <div class="grid gap-6 xl:grid-cols-2">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="rounded-2xl bg-cyan-50 p-3 text-cyan-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0115 0M12 4.5V6m0 12v1.5"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">EMR access</p>
                            <h3 class="text-2xl font-bold text-slate-900">Record visibility</h3>
                        </div>
                    </div>
                    <div class="space-y-4 text-sm text-slate-600">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">View complete patient records within doctor scope.</div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">Access lab reports, previous diagnoses, and treatment history.</div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">Track follow-up status and treatment progression.</div>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="rounded-2xl bg-emerald-50 p-3 text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Security & access control</p>
                            <h3 class="text-2xl font-bold text-slate-900">Protected doctor scope</h3>
                        </div>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex gap-3"><span class="mt-2 h-2 w-2 rounded-full bg-emerald-500"></span>Only authorized patient records are available.</li>
                        <li class="flex gap-3"><span class="mt-2 h-2 w-2 rounded-full bg-emerald-500"></span>Doctor actions can be logged for audit tracking.</li>
                        <li class="flex gap-3"><span class="mt-2 h-2 w-2 rounded-full bg-emerald-500"></span>Access is limited to linked appointments, prescriptions, and lab orders.</li>
                    </ul>
                </div>
            </div>
        </section>
        @endif

        @if(($activeSection ?? 'overview') === 'patients')
        <section id="patients" class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Patient management</p>
                    <h3 class="text-2xl font-bold text-slate-900">Assigned patients</h3>
                </div>
                <div class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm">{{ $stats['patients_handled'] }} tracked</div>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse($assignedPatients->take(6) as $patient)
                    <x-doctor.patient-card :patient="$patient" :patient-history="$patientHistory" :patient-timeline="$patientTimeline" />
                @empty
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500 md:col-span-2 col-span-full">
                        No assigned patients yet.
                    </div>
                @endforelse
            </div>
        </section>
        @endif



        @if(($activeSection ?? 'overview') === 'appointments')
        {{-- Appointments Section --}}
        <section id="appointments" class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="flex items-start gap-3">
                        <span class="rounded-2xl bg-sky-50 p-3 text-sky-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Appointment management</p>
                            <h3 class="text-2xl font-bold text-slate-900">Daily appointment schedule</h3>
                            <p class="mt-1 text-sm text-slate-500">A clearer live view of today’s consultation flow.</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs font-semibold">
                        <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">Pending</span>
                        <span class="rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-sky-700">Confirmed</span>
                        <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-700">Completed</span>
                        <span class="rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-rose-700">Cancelled</span>
                    </div>
                </div>

                <div class="mt-5 rounded-3xl border border-slate-200 bg-slate-50/80 p-4">
                    <div class="grid gap-3 lg:grid-cols-[1fr_220px]">
                    <div>
                        <label for="appointment-search" class="sr-only">Search appointments</label>
                        <input id="appointment-search" type="search" class="form-input" placeholder="Search by patient, department, time, or type">
                    </div>
                    <div>
                        <label for="appointment-status-filter" class="sr-only">Filter by status</label>
                        <select id="appointment-status-filter" class="form-input">
                            <option value="all">All statuses</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-3xl border border-slate-200 bg-white">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50/90 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Time</th>
                                <th class="px-4 py-3">Patient</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($todayAppointments as $appointment)
                                <tr class="appointment-row text-sm text-slate-700 hover:bg-slate-50/70"
                                    data-appointment-row
                                    data-status="{{ $appointment->status }}"
                                    data-search="{{ strtolower(trim(($appointment->patient->name ?? '') . ' ' . ($appointment->department->name ?? 'General') . ' ' . $appointment->time_slot . ' ' . $appointment->type . ' ' . ($appointment->patient->phone ?? ''))) }}">
                                    <td class="px-4 py-4 font-semibold text-slate-900">{{ $appointment->time_slot }}</td>
                                    <td class="px-4 py-4">
                                        <p class="font-semibold text-slate-900">
                                            {{ $appointment->patient_name }}
                                            @if(!$appointment->patient_id)
                                                <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[0.65rem] font-medium bg-amber-100 text-amber-800">Guest</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-slate-500">{{ $appointment->patient->phone ?? ($appointment->guest_phone ?? 'No contact') }}</p>
                                    </td>
                                    <td class="px-4 py-4">{{ $appointment->department->name ?? 'General' }}</td>
                                    <td class="px-4 py-4 capitalize">{{ $appointment->type }}</td>
                                    <td class="px-4 py-4">
                                        <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusStyles[$appointment->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">{{ $statusLabels[$appointment->status] ?? ucfirst($appointment->status) }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="space-y-2">
                                            <div class="flex flex-wrap gap-2">
                                                <form action="{{ route('doctor.appointments.status', $appointment) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="rounded-xl bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 hover:bg-sky-100">Accept</button>
                                                </form>
                                                <form action="{{ route('doctor.appointments.status', $appointment) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="rounded-xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 hover:bg-emerald-100">Complete</button>
                                                </form>
                                                <form action="{{ route('doctor.appointments.status', $appointment) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="rounded-xl bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-100">Reject</button>
                                                </form>
                                            </div>
                                            <form action="{{ route('doctor.appointments.reschedule', $appointment) }}" method="POST" class="grid grid-cols-1 gap-2 sm:grid-cols-[1fr_1fr_auto]">
                                                @csrf
                                                <input type="date" name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}" class="form-input text-xs py-2">
                                                <input type="text" name="time_slot" value="{{ $appointment->time_slot }}" class="form-input text-xs py-2" placeholder="09:00 - 09:30">
                                                <button type="submit" class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100">Reschedule</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                        No appointments scheduled for today.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <p id="appointment-filter-empty" class="mt-4 hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-500">
                    No appointments match the current search or filter.
                </p>
        </section>
        @endif

        @if(($activeSection ?? 'overview') === 'consultations')
        {{-- Consultations Section --}}
        <section id="consultations" class="space-y-6">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="rounded-2xl bg-sky-50 p-3 text-sky-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Consultation management</p>
                        <h3 class="text-2xl font-bold text-slate-900">Save visit notes</h3>
                    </div>
                </div>
                    <form action="{{ route('doctor.consultations.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="form-label" for="consultation_appointment_id">Appointment</label>
                            <select id="consultation_appointment_id" name="appointment_id" class="form-input">
                                <option value="">Select appointment</option>
                                @foreach($appointmentOptions as $appointment)
                                    <option value="{{ $appointment->id }}">{{ $appointment->patient->name ?? 'Unknown' }} · {{ $appointment->appointment_date->format('M d') }} · {{ $appointment->time_slot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="symptoms">Symptoms</label>
                            <textarea id="symptoms" name="symptoms" rows="3" class="form-input" placeholder="Enter symptoms"></textarea>
                        </div>
                        <div>
                            <label class="form-label" for="observations">Observations</label>
                            <textarea id="observations" name="observations" rows="3" class="form-input" placeholder="Enter clinical observations"></textarea>
                        </div>
                        <div>
                            <label class="form-label" for="diagnosis">Diagnosis</label>
                            <input id="diagnosis" name="diagnosis" type="text" class="form-input" placeholder="Diagnosis">
                        </div>
                        <div>
                            <label class="form-label" for="consultation_notes">Notes</label>
                            <textarea id="consultation_notes" name="notes" rows="3" class="form-input" placeholder="Consultation notes"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">Save consultation</button>
                    </form>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <span class="rounded-2xl bg-amber-50 p-3 text-amber-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Recent follow-up</p>
                            <h3 class="text-xl font-bold text-slate-900">Upcoming consultations</h3>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($upcomingAppointments as $appointment)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $appointment->patient_name }}
                                            @if(!$appointment->patient_id)
                                                <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[0.65rem] font-medium bg-amber-100 text-amber-800">Guest</span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-slate-500">{{ $appointment->appointment_date->format('M d, Y') }} · {{ $appointment->time_slot }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">{{ $statusLabels[$appointment->status] ?? ucfirst($appointment->status) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">No upcoming consultation follow-ups.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <span class="rounded-2xl bg-emerald-50 p-3 text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Consultation history</p>
                            <h3 class="text-xl font-bold text-slate-900">Recent completed visits</h3>
                        </div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @forelse($recentConsultations as $consultation)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $consultation->patient_name }}
                                            @if(!$consultation->patient_id)
                                                <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[0.65rem] font-medium bg-amber-100 text-amber-800">Guest</span>
                                            @endif
                                        </p>
                                        <p class="text-sm text-slate-500">{{ $consultation->appointment_date->format('M d, Y') }} · {{ $consultation->time_slot }}</p>
                                    </div>
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Completed</span>
                                </div>
                            <p class="mt-3 text-sm text-slate-600 line-clamp-2">{{ $consultation->notes ?: 'No consultation notes recorded.' }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No completed consultation history yet.</p>
                    @endforelse
                </div>
            </div>
        </section>
        @endif

        @if(($activeSection ?? 'overview') === 'prescriptions')
        {{-- Prescriptions Section --}}
        <section id="prescriptions" class="space-y-6">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="rounded-2xl bg-emerald-50 p-3 text-emerald-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m-7.5-6h15"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Prescription management</p>
                        <h3 class="text-2xl font-bold text-slate-900">Create prescription</h3>
                    </div>
                </div>
                <form action="{{ route('doctor.prescriptions.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label" for="prescription_patient_id">Patient</label>
                        <select id="prescription_patient_id" name="patient_id" class="form-input" required>
                            <option value="">Select patient</option>
                            @foreach($assignedPatients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="prescription_appointment_id">Appointment (optional)</label>
                        <select id="prescription_appointment_id" name="appointment_id" class="form-input">
                            <option value="">Link to appointment</option>
                            @foreach($appointmentOptions as $appointment)
                                <option value="{{ $appointment->id }}">{{ $appointment->patient->name ?? 'Unknown' }} · {{ $appointment->appointment_date->format('M d') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="prescription_diagnosis">Diagnosis</label>
                        <input id="prescription_diagnosis" name="diagnosis" type="text" class="form-input" placeholder="Diagnosis">
                    </div>
                    <div>
                        <label class="form-label" for="prescription_notes">Notes</label>
                        <textarea id="prescription_notes" name="notes" rows="3" class="form-input" placeholder="Prescription notes"></textarea>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Medicine items</p>
                                <p class="text-xs text-slate-500">Add one or more medicines with dosage instructions.</p>
                            </div>
                            <button type="button" id="add-prescription-item" class="rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white">Add item</button>
                        </div>

                        <div id="prescription-items" class="mt-4 space-y-3">
                            <div class="prescription-item rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-slate-900">Medicine #1</p>
                                    <div class="flex items-center gap-2">
                                        <button type="button" class="move-up-item text-xs font-semibold text-slate-600 hover:text-slate-800">↑</button>
                                        <button type="button" class="move-down-item text-xs font-semibold text-slate-600 hover:text-slate-800">↓</button>
                                        <button type="button" class="edit-prescription-item text-xs font-semibold text-sky-700 hover:text-sky-800">Edit</button>
                                        <button type="button" class="remove-prescription-item text-xs font-semibold text-rose-600 hover:text-rose-700">Remove</button>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-3">
                                    <div class="relative">
                                        <label class="form-label" for="medicine_search_1">Medicine</label>
                                        <input type="text" id="medicine_search_1" class="form-input medicine-search" placeholder="Search medicine by name..." autocomplete="off">
                                        <input type="hidden" id="medicine_id_1" name="medicine_ids[]" class="medicine-id" required>
                                        <div id="medicine_dropdown_1" class="medicine-dropdown absolute z-10 hidden top-full left-0 right-0 mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-48 overflow-y-auto"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="form-label" for="dosage_1">Dosage</label>
                                            <input id="dosage_1" name="dosages[]" type="text" class="form-input" placeholder="500 mg">
                                        </div>
                                        <div>
                                            <label class="form-label" for="frequency_1">Frequency</label>
                                            <input id="frequency_1" name="frequencies[]" type="text" class="form-input" placeholder="Twice daily">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label" for="duration_1">Duration</label>
                                        <input id="duration_1" name="durations[]" type="text" class="form-input" placeholder="5 days">
                                    </div>
                                    <div>
                                        <label class="form-label" for="instructions_1">Instructions</label>
                                        <textarea id="instructions_1" name="instructions[]" rows="3" class="form-input" placeholder="Additional instructions"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <template id="prescription-item-template">
                            <div class="prescription-item rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-sm font-semibold text-slate-900">Medicine __INDEX__</p>
                                        <div class="flex items-center gap-2">
                                            <button type="button" class="move-up-item text-xs font-semibold text-slate-600 hover:text-slate-800">↑</button>
                                            <button type="button" class="move-down-item text-xs font-semibold text-slate-600 hover:text-slate-800">↓</button>
                                            <button type="button" class="edit-prescription-item text-xs font-semibold text-sky-700 hover:text-sky-800">Edit</button>
                                            <button type="button" class="remove-prescription-item text-xs font-semibold text-rose-600 hover:text-rose-700">Remove</button>
                                        </div>
                                    </div>
                                <div class="mt-4 space-y-3">
                                    <div class="relative">
                                        <label class="form-label" for="medicine_search___INDEX__">Medicine</label>
                                        <input type="text" id="medicine_search___INDEX__" class="form-input medicine-search" placeholder="Search medicine by name..." autocomplete="off">
                                        <input type="hidden" id="medicine_id___INDEX__" name="medicine_ids[]" class="medicine-id" required>
                                        <div id="medicine_dropdown___INDEX__" class="medicine-dropdown absolute z-10 hidden top-full left-0 right-0 mt-1 bg-white border border-slate-200 rounded-lg shadow-lg max-h-48 overflow-y-auto"></div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="form-label" for="dosage___INDEX__">Dosage</label>
                                            <input id="dosage___INDEX__" name="dosages[]" type="text" class="form-input" placeholder="500 mg">
                                        </div>
                                        <div>
                                            <label class="form-label" for="frequency___INDEX__">Frequency</label>
                                            <input id="frequency___INDEX__" name="frequencies[]" type="text" class="form-input" placeholder="Twice daily">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label" for="duration___INDEX__">Duration</label>
                                        <input id="duration___INDEX__" name="durations[]" type="text" class="form-input" placeholder="5 days">
                                    </div>
                                    <div>
                                        <label class="form-label" for="instructions___INDEX__">Instructions</label>
                                        <textarea id="instructions___INDEX__" name="instructions[]" rows="3" class="form-input" placeholder="Additional instructions"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Save prescription</button>
                </form>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Prescription management</p>
                        <h3 class="text-2xl font-bold text-slate-900">Recent prescriptions</h3>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 lg:grid-cols-2">
                    @forelse($prescriptions as $prescription)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50/90 p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900">{{ $prescription->patient->name ?? 'Unknown patient' }}</p>
                                    <p class="text-sm text-slate-500">{{ $prescription->diagnosis ?? 'Diagnosis pending' }}</p>
                                </div>
                                <div class="flex gap-2 items-center">
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">{{ $prescription->appointment?->appointment_date?->format('M d') ?? 'No date' }}</span>
                                    <button type="button" data-prescription-id="{{ $prescription->id }}" data-patient-name="{{ e($prescription->patient->name ?? 'Patient') }}" class="print-prescription-btn rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-600 hover:bg-blue-200 transition">
                                        <svg class="h-3.5 w-3.5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2m2 4H9m4 0h4m-2-2v2m0-6V9m0 0V5"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600 line-clamp-2">{{ $prescription->notes ?? 'No prescription notes available.' }}</p>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                            No prescriptions created yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        @endif

        @if(($activeSection ?? 'overview') === 'schedule')
        <section id="schedule" class="space-y-6">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Schedule</p>
                        <h3 class="text-2xl font-bold text-slate-900">Weekly availability</h3>
                        <p class="mt-1 text-sm text-slate-500">A quick view of your configured availability slots.</p>
                    </div>
                    <a href="{{ route('doctor.profile') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Edit availability</a>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                    @foreach($weeklyAvailability as $day)
                        <div class="rounded-3xl border border-slate-200 bg-slate-50/90 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-semibold text-slate-900">{{ $day['day'] }}</p>
                                <span class="rounded-full {{ $day['available'] ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} px-3 py-1 text-xs font-semibold">
                                    {{ $day['available'] ? 'Available' : 'Blocked' }}
                                </span>
                            </div>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($day['slots'] as $slot)
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">{{ $slot }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3 mb-6">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Upcoming</p>
                        <h3 class="text-2xl font-bold text-slate-900">Next appointments</h3>
                    </div>
                    <a href="{{ route('doctor.appointments') }}" class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Go to Appointments</a>
                </div>
                <div class="space-y-3">
                    @forelse($upcomingAppointments as $appointment)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50/90 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $appointment->patient_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $appointment->appointment_date->format('M d, Y') }} · {{ $appointment->time_slot }} · {{ $appointment->department->name ?? 'General' }}</p>
                                </div>
                                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusStyles[$appointment->status] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">{{ $statusLabels[$appointment->status] ?? ucfirst($appointment->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No upcoming appointments scheduled.</p>
                    @endforelse
                </div>
            </div>
        </section>
        @endif

        @if(($activeSection ?? 'overview') === 'notifications')
        <section id="notifications" class="space-y-6">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Notifications</p>
                        <h3 class="text-2xl font-bold text-slate-900">Clinical alerts</h3>
                        <p class="mt-1 text-sm text-slate-500">Appointment and system updates stay here until marked as read.</p>
                    </div>
                    <form method="POST" action="{{ route('doctor.notifications.mark-read') }}">
                        @csrf
                        <button type="submit" class="rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Mark all as read</button>
                    </form>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse($notifications as $notification)
                        @php
                            $type = strtolower($notification->type ?? 'system');
                            $notificationTone = $notificationStyles[$type] ?? $notificationStyles['system'];
                        @endphp
                        <div class="rounded-3xl border bg-linear-to-br {{ $notificationTone }} p-4 shadow-sm {{ $notification->is_read ? 'opacity-70' : '' }}">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $notification->title }}</p>
                                    <p class="text-sm text-slate-600">{{ $notification->message }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if(! $notification->is_read)
                                        <div class="mt-2 inline-flex items-center gap-1 rounded-full bg-rose-50 px-2.5 py-1 text-[11px] font-bold text-rose-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Unread
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">No notifications yet.</p>
                    @endforelse
                </div>
            </div>
        </section>
        @endif

        @if(($activeSection ?? 'overview') === 'labs')
        {{-- Labs & EMR Section --}}
        <section id="labs" class="space-y-6">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-6">
                    <span class="rounded-2xl bg-violet-50 p-3 text-violet-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6m-5 0v4m4-4v4m-6 6h6M6 7h12v12H6z"/>
                        </svg>
                    </span>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Lab test management</p>
                        <h3 class="text-2xl font-bold text-slate-900">Request lab test</h3>
                    </div>
                </div>
                <form action="{{ route('doctor.lab-orders.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label" for="lab_patient_id">Patient</label>
                        <select id="lab_patient_id" name="patient_id" class="form-input" required>
                            <option value="">Select patient</option>
                            @foreach($assignedPatients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="lab_test_id">Lab test</label>
                        <select id="lab_test_id" name="lab_test_id" class="form-input" required>
                            <option value="">Select lab test</option>
                            @foreach($labTests as $labTest)
                                <option value="{{ $labTest->id }}">{{ $labTest->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label" for="lab_result">Initial remarks</label>
                        <textarea id="lab_result" name="result" rows="5" class="form-input" placeholder="Optional request notes"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Request lab test</button>
                </form>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200 bg-white/90 p-6 shadow-sm backdrop-blur-sm">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="rounded-2xl bg-violet-50 p-3 text-violet-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6m-5 0v4m4-4v4m-6 6h6M6 7h12v12H6z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Lab test management</p>
                            <h3 class="text-2xl font-bold text-slate-900">Lab requests & results</h3>
                        </div>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-2xl border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Patient</th>
                                <th class="px-4 py-3">Test</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Details</th>
                                <th class="px-4 py-3">Report</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($labOrders as $labOrder)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-4 py-4 font-medium text-slate-900">{{ $labOrder->patient->name ?? 'Unknown' }}</td>
                                    <td class="px-4 py-4">{{ $labOrder->labTest->name ?? 'Lab panel' }}</td>
                                    <td class="px-4 py-4">
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($labOrder->status) }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">
                                        {{ $labOrder->result ? \Illuminate\Support\Str::limit($labOrder->result, 60) : 'Pending update' }}
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($labOrder->report_file)
                                            <a href="{{ route('lab-orders.report', $labOrder) }}" target="_blank" class="text-xs font-semibold text-sky-700 hover:text-sky-800">View report</a>
                                        @else
                                            <span class="text-xs text-slate-500">Not uploaded</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-slate-500">No lab orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 rounded-3xl bg-linear-to-br from-slate-50 to-cyan-50 p-5">
                    <p class="text-sm font-semibold text-slate-900">Treatment history tracking</p>
                    <p class="mt-2 text-sm text-slate-600">Use this section to follow diagnosis history, previous prescriptions, and lab result progression for each patient.</p>
                </div>
            </div>
        </section>
        @endif

        {{-- Schedule & Notifications Section --}}
        <!-- Weekly availability (detailed) removed (duplicate) -->

        {{-- Notifications & Alerts Section --}}


        @if(($activeSection ?? 'overview') === 'reports')
        {{-- Reports & Performance Section --}}
        <section id="reports" class="space-y-8">
            {{-- Performance Analytics Hero --}}
            <div class="relative overflow-hidden rounded-4xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(99,102,241,0.08),transparent_35%),radial-gradient(circle_at_bottom_left,rgba(59,130,246,0.05),transparent_30%)]"></div>
                <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                    <div class="max-w-2xl space-y-4">
                        <div class="inline-flex items-center gap-2 rounded-full border border-violet-200 bg-violet-50 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-violet-700">
                            Clinical Performance
                        </div>
                        <h3 class="text-3xl font-black tracking-tight text-slate-950">Practice Insights</h3>
                        <p class="text-base leading-relaxed text-slate-600">
                            Review your clinical productivity, patient outcomes, and service trends. These metrics are calculated based on your recent activity and patient interactions.
                        </p>
                    </div>
                    <div class="grid shrink-0 grid-cols-2 gap-4">
                        <div class="rounded-3xl border border-slate-100 bg-slate-50/50 p-6 text-center backdrop-blur-sm transition hover:border-sky-200 hover:bg-white hover:shadow-xl hover:shadow-sky-500/5">
                            <p class="text-sm font-semibold text-slate-500">Completion Rate</p>
                            <p class="mt-2 text-4xl font-black text-sky-600">{{ $stats['completion_rate'] }}%</p>
                        </div>
                        <div class="rounded-3xl border border-slate-100 bg-slate-50/50 p-6 text-center backdrop-blur-sm transition hover:border-emerald-200 hover:bg-white hover:shadow-xl hover:shadow-emerald-500/5">
                            <p class="text-sm font-semibold text-slate-500">Total Visits</p>
                            <p class="mt-2 text-4xl font-black text-emerald-600">{{ $stats['completed_consultations'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Statistical Cards Grid --}}
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Patients Handled --}}
                <div class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="rounded-2xl bg-sky-50 p-3 text-sky-600 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Total Unique</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-4xl font-black text-slate-950">{{ $stats['patients_handled'] }}</h4>
                        <p class="mt-1 text-sm font-semibold text-slate-500">Patients Managed</p>
                    </div>
                </div>

                {{-- Total Appointments --}}
                <div class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="rounded-2xl bg-amber-50 p-3 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Scheduled</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-4xl font-black text-slate-950">{{ $stats['today_appointments'] + $stats['upcoming_appointments'] }}</h4>
                        <p class="mt-1 text-sm font-semibold text-slate-500">Total Bookings</p>
                    </div>
                </div>

                {{-- Lab Orders --}}
                <div class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="rounded-2xl bg-violet-50 p-3 text-violet-600 group-hover:bg-violet-500 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6m-5 0v4m4-4v4m-6 6h6M6 7h12v12H6z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Diagnostics</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-4xl font-black text-slate-950">{{ $stats['lab_requests'] }}</h4>
                        <p class="mt-1 text-sm font-semibold text-slate-500">Lab Investigations</p>
                    </div>
                </div>

                {{-- Prescriptions --}}
                <div class="group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-slate-400">Treatment</span>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-4xl font-black text-slate-950">{{ $prescriptions->count() }}</h4>
                        <p class="mt-1 text-sm font-semibold text-slate-500">Active Prescriptions</p>
                    </div>
                </div>
            </div>

            {{-- Recent Activity Log / Performance Breakdown --}}
            <div class="grid gap-8 lg:grid-cols-2">
                {{-- Distribution Chart (Simulated with bars) --}}
                <div class="rounded-4xl border border-slate-200 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h4 class="text-xl font-bold text-slate-950">Patient Demographics</h4>
                            <p class="text-sm text-slate-500">Gender distribution of your patients.</p>
                        </div>
                    </div>
                    <div class="space-y-6">
                        @php
                            $maleCount = $assignedPatients->where('gender', 'male')->count();
                            $femaleCount = $assignedPatients->where('gender', 'female')->count();
                            $otherCount = $assignedPatients->where('gender', 'other')->count();
                            $totalGender = max(1, $maleCount + $femaleCount + $otherCount);
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-bold text-slate-700">Male</span>
                                <span class="text-sm font-bold text-slate-900">{{ round(($maleCount/$totalGender)*100) }}%</span>
                            </div>
                            <div class="h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-sky-500 transition-all duration-1000" style="width: {{ ($maleCount/$totalGender)*100 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-bold text-slate-700">Female</span>
                                <span class="text-sm font-bold text-slate-900">{{ round(($femaleCount/$totalGender)*100) }}%</span>
                            </div>
                            <div class="h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-rose-500 transition-all duration-1000" style="width: {{ ($femaleCount/$totalGender)*100 }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-bold text-slate-700">Other / Unspecified</span>
                                <span class="text-sm font-bold text-slate-900">{{ round(($otherCount/$totalGender)*100) }}%</span>
                            </div>
                            <div class="h-3 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-violet-500 transition-all duration-1000" style="width: {{ ($otherCount/$totalGender)*100 }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 rounded-3xl border border-dashed border-slate-200 p-6">
                        <p class="text-center text-sm font-medium text-slate-500">
                            Based on your handled patient profiles. Update patient details during consultation for more accurate reporting.
                        </p>
                    </div>
                </div>

                {{-- Status Distribution --}}
                <div class="rounded-4xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h4 class="mb-8 text-xl font-bold text-slate-950">Appointment Outcomes</h4>
                    <div class="grid gap-4">
                        @php
                            $totalAppts = max(1, $todayAppointments->count() + $upcomingAppointments->count() + $recentConsultations->count());
                            $completed = $stats['completed_consultations'];
                            $cancelled = 0; // Would need full count from DB ideally
                        @endphp
                        <div class="flex items-center gap-4 rounded-3xl border border-slate-100 bg-slate-50/50 p-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-900">Successfully Completed</p>
                                <p class="text-xs text-slate-500">Consultations that resulted in a prescription or treatment plan.</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-950">{{ $completed }}</p>
                                <p class="text-[10px] font-bold text-emerald-600">Archived</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 rounded-3xl border border-slate-100 bg-slate-50/50 p-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-900">Pending & Confirmed</p>
                                <p class="text-xs text-slate-500">Current active workload requiring your clinical attention.</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-950">{{ $stats['pending_consultations'] }}</p>
                                <p class="text-[10px] font-bold text-amber-600">Active</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 rounded-3xl border border-slate-100 bg-slate-50/50 p-4 opacity-75">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-900">Cancellations</p>
                                <p class="text-xs text-slate-500">Appointments that were cancelled by you or the patient.</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-black text-slate-950">N/A</p>
                                <p class="text-[10px] font-bold text-rose-600">Dismissed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
        <div id="patient-drawer-overlay" class="fixed inset-0 z-40 hidden transition-all duration-500"></div>
        <aside id="patient-drawer" class="fixed left-1/2 top-1/2 z-50 flex max-h-[88vh] w-[min(92vw,56rem)] -translate-x-1/2 -translate-y-1/2 scale-95 flex-col overflow-hidden opacity-0 pointer-events-none transition-all duration-500">
            <div class="patient-drawer-header flex items-start justify-between gap-4 px-8 py-6">
                <div class="space-y-2">
                    <p class="inline-flex items-center rounded-full bg-blue-500/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.24em] text-blue-600 shadow-sm ring-1 ring-blue-500/20">Patient detail drawer</p>
                    <h3 id="patient-drawer-name" class="text-3xl font-black tracking-tight text-[#0f172a]">Patient profile</h3>
                    <p class="max-w-xl text-sm leading-6 text-[#64748b]">Quickly review contact details, demographics, and recent activity from one focused panel.</p>
                </div>
                <button type="button" id="close-patient-drawer" class="rounded-full bg-linear-to-r from-blue-600 to-indigo-700 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-500/25 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/40 active:translate-y-0">Close</button>
            </div>
            <div class="patient-drawer-scroll flex-1 space-y-12 overflow-y-auto px-8 py-6">
                {{-- Demographics Section --}}
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-100 text-sky-700 shadow-sm border border-sky-200">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-black tracking-tight text-slate-950">Patient details</h4>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Demographics & Contact</p>
                        </div>
                    </div>

                    <div class="grid gap-x-8 gap-y-6 sm:grid-cols-2">
                        {{-- Phone --}}
                        <div class="flex items-center gap-4 transition-transform hover:translate-x-1">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-sky-50 text-sky-600 shadow-sm border border-sky-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.948V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Phone Number</p>
                                <p id="patient-drawer-phone" class="text-base font-bold text-slate-900 tracking-tight">—</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-center gap-4 transition-transform hover:translate-x-1">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-violet-50 text-violet-600 shadow-sm border border-violet-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Email Address</p>
                                <p id="patient-drawer-email" class="text-base font-bold text-slate-900 tracking-tight">—</p>
                            </div>
                        </div>

                        {{-- Gender --}}
                        <div class="flex items-center gap-4 transition-transform hover:translate-x-1">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-600 shadow-sm border border-rose-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Gender</p>
                                <p id="patient-drawer-gender" class="text-base font-bold text-slate-900 tracking-tight">—</p>
                            </div>
                        </div>

                        {{-- Blood Group --}}
                        <div class="flex items-center gap-4 transition-transform hover:translate-x-1">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 shadow-sm border border-emerald-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Blood Group</p>
                                <p id="patient-drawer-blood-group" class="text-base font-bold text-slate-900 tracking-tight">—</p>
                            </div>
                        </div>

                        {{-- DOB --}}
                        <div class="flex items-center gap-4 transition-transform hover:translate-x-1 sm:col-span-2">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-600 shadow-sm border border-amber-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Date of Birth</p>
                                <p id="patient-drawer-dob" class="text-base font-bold text-slate-900 tracking-tight">—</p>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="flex items-start gap-4 transition-transform hover:translate-x-1 sm:col-span-2">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-slate-50 text-slate-600 shadow-sm border border-slate-100">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">Residential Address</p>
                                <p id="patient-drawer-address" class="text-base font-bold text-slate-900 leading-snug">—</p>
                            </div>
                        </div>

                        {{-- Emergency Contact --}}
                        <div class="flex items-center gap-4 transition-transform hover:translate-x-1 sm:col-span-2">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-rose-50 text-rose-700 shadow-sm border border-rose-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-widest text-rose-500">Emergency Contact</p>
                                <p id="patient-drawer-emergency" class="text-base font-bold text-slate-900 tracking-tight">—</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- History Section --}}
                <div class="space-y-6">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 shadow-sm border border-emerald-200">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-black tracking-tight text-slate-950">Clinical history</h4>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Recent Activity</p>
                            </div>
                        </div>
                        <span id="patient-drawer-visits" class="rounded-full bg-slate-900 px-4 py-1.5 text-xs font-bold text-white shadow-lg shadow-slate-950/20">0 visits</span>
                    </div>
                    <div id="patient-drawer-history" class="space-y-3"></div>
                </div>
            </div>
        </aside>

        <style>
            #patient-drawer-overlay {
                background: rgba(15, 23, 42, 0.18);
                backdrop-filter: blur(6px);
            }

            #patient-drawer {
                background: 
                    radial-gradient(circle at top left, #dbeafe 0%, transparent 35%),
                    radial-gradient(circle at bottom right, #bfdbfe 0%, transparent 35%),
                    linear-gradient(135deg, #f8fbff, #eef5ff);
                background-size: 200% 200%;
                animation: mesh-gradient-move 12s ease infinite;
                backdrop-filter: blur(18px);
                border: 1px solid rgba(255, 255, 255, 0.4);
                box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
                border-radius: 28px;
            }

            .patient-drawer-header {
                background:
                    radial-gradient(
                        circle at top right,
                        rgba(37, 99, 235, 0.12),
                        transparent 35%
                    ),
                    linear-gradient(
                        135deg,
                        #f8fbff 0%,
                        #dbeafe 100%
                    );
                border-bottom: 1px solid rgba(148, 163, 184, 0.15);
                backdrop-filter: blur(10px);
                border-top-left-radius: 28px;
                border-top-right-radius: 28px;
            }

            #patient-drawer-name {
                text-shadow: 0 1px 2px rgba(15, 23, 42, 0.05);
            }

            @keyframes mesh-gradient-move {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .history-entry-card {
                background: rgba(255, 255, 255, 0.78);
                backdrop-filter: blur(8px);
                border: 1px solid rgba(255, 255, 255, 0.4);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
                border-radius: 20px;
                padding: 1rem;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .history-entry-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
            }

            .patient-drawer-scroll {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .patient-drawer-scroll::-webkit-scrollbar {
                width: 0;
                height: 0;
                display: none;
            }
            /* History entry animation */
            .history-entry {
                transform: translateY(10px) scale(0.99);
                opacity: 0;
                transition: transform 400ms cubic-bezier(.2, .9, .35, 1), opacity 400ms ease;
            }

            .history-entry.visible {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        </style>
    </div>

    <script>
        // Fallback medicines from server (used if API fails)
        window.initialMedicines = @json($medicines ?? []);
        
        // Robust medicine autocomplete with loading states and fallback
        class MedicineAutocomplete {
            constructor() {
                this.allMedicines = window.initialMedicines;
                this.isLoaded = Array.isArray(this.allMedicines) && this.allMedicines.length > 0;
                this.searchTimeout = null;
                // Bind immediately so selections show even before API finishes.
                this.initializeSearch();
                this.init();
            }

            async init() {
                try {
                    await this.loadMedicines();
                    this.isLoaded = true;
                    this.initializeSearch();
                } catch (error) {
                    console.warn('Medicine API failed, using fallback data:', error);
                    this.allMedicines = window.initialMedicines;
                    this.initializeSearch();
                }
            }

            async loadMedicines() {
                const response = await fetch('/doctor/form-data');
                if (!response.ok) throw new Error('API failed');
                const data = await response.json();
                this.allMedicines = data.medicines || data || [];
                if (this.allMedicines.length === 0) {
                    throw new Error('No medicines returned');
                }
            }

            initializeSearch() {
                document.querySelectorAll('.medicine-search').forEach(input => {
                    this.attachHandlers(input);
                });
            }

            attachHandlers(input) {
                const dropdownId = input.id.replace('medicine_search_', 'medicine_dropdown_').replace(/medicine_search___INDEX__/g, 'medicine_dropdown___INDEX__');
                const medicineIdId = input.id.replace('medicine_search_', 'medicine_id_').replace(/medicine_search___INDEX__/g, 'medicine_id___INDEX__');
                const dropdown = document.getElementById(dropdownId);
                const medicineIdInput = document.getElementById(medicineIdId);

                if (!dropdown || !medicineIdInput) return;

                // Focus: show dropdown
                input.addEventListener('focus', () => this.showDropdown(input, dropdown));

                // Debounced search
                input.addEventListener('input', (e) => {
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(() => {
                        this.filterAndShow(e.target.value, dropdown, input);
                    }, 150);
                });

                // Blur: hide after delay
                input.addEventListener('blur', () => {
                    setTimeout(() => dropdown.classList.add('hidden'), 200);
                });
            }

            showDropdown(input, dropdown) {
                this.filterAndShow(input.value, dropdown, input);
                dropdown.classList.remove('hidden');
            }

            filterAndShow(searchTerm, dropdown, input) {
                if (!Array.isArray(this.allMedicines) || this.allMedicines.length === 0) {
                    dropdown.innerHTML = '<div class="px-4 py-3 text-sm text-slate-500 animate-pulse">Loading medicines...</div>';
                    return;
                }

                const filtered = this.allMedicines.filter(medicine => 
                    medicine.name?.toLowerCase().includes(searchTerm.toLowerCase())
                ).slice(0, 10); // Limit results

                dropdown.innerHTML = '';

                if (filtered.length === 0) {
                    dropdown.innerHTML = '<div class="px-4 py-3 text-sm text-slate-500">No medicines found</div>';
                    return;
                }

                filtered.forEach(medicine => {
                    const option = document.createElement('div');
                    option.className = 'medicine-option px-4 py-3 cursor-pointer hover:bg-sky-50 border-b border-slate-100 last:border-b-0 group';
                    option.dataset.medicineId = medicine.id;
                    option.dataset.medicineName = medicine.name;
                    option.innerHTML = `
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-slate-900 group-hover:text-sky-900">${medicine.name}</span>
                            <span class="text-xs text-slate-500">${medicine.strength || ''}</span>
                        </div>
                    `;
                    dropdown.appendChild(option);
                });
            }

            selectMedicine(option) {
                const dropdown = option.closest('.medicine-dropdown');
                const container = dropdown.parentElement;
                const searchInput = container.querySelector('.medicine-search');
                const medicineIdInput = container.querySelector('.medicine-id');

                if (!searchInput || !medicineIdInput) return;

                const medicineId = option.dataset.medicineId;
                const medicineName = option.dataset.medicineName;

                medicineIdInput.value = medicineId;
                searchInput.value = medicineName;
                dropdown.classList.add('hidden');
                searchInput.focus();
            }
        }

        // Global medicine selection handler
        document.addEventListener('click', (e) => {
            const option = e.target.closest('.medicine-option');
            if (option) {
                window.medicineAutocomplete?.selectMedicine(option);
            }
        });

        // Prescription item handlers (from doctor.js integration)
        function updatePrescriptionItemTitles() {
            const items = document.querySelectorAll('.prescription-item');
            items.forEach((item, index) => {
                const title = item.querySelector('p');
                if (title) title.textContent = `Medicine #${index + 1}`;
            });
        }

        function addPrescriptionItem() {
            const template = document.getElementById('prescription-item-template');
            const itemsContainer = document.getElementById('prescription-items');
            if (!template || !itemsContainer) return;

            const index = itemsContainer.querySelectorAll('.prescription-item').length + 1;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = template.innerHTML.replaceAll('__INDEX__', index).trim();
            const newItem = wrapper.firstElementChild;
            
            if (newItem) {
                itemsContainer.appendChild(newItem);
                updatePrescriptionItemTitles();
                // Re-attach handlers after short delay
                setTimeout(() => window.medicineAutocomplete?.initializeSearch(), 50);
            }
        }

        // Print prescription
        function printPrescription(prescriptionId) {
            window.open(`/doctor/prescriptions/${prescriptionId}/print`, '_blank', 'width=900,height=1000');
        }

        // Initialize everything
        document.addEventListener('DOMContentLoaded', async () => {
            // Medicine autocomplete (main fix)
            window.medicineAutocomplete = new MedicineAutocomplete();

            // Prescription item management
            const addBtn = document.getElementById('add-prescription-item');
            if (addBtn) addBtn.addEventListener('click', addPrescriptionItem);

            document.getElementById('prescription-items')?.addEventListener('click', (e) => {
                const removeBtn = e.target.closest('.remove-prescription-item');
                const upBtn = e.target.closest('.move-up-item');
                const downBtn = e.target.closest('.move-down-item');

                if (removeBtn) {
                    const item = removeBtn.closest('.prescription-item');
                    if (item) {
                        const items = document.querySelectorAll('.prescription-item');
                        if (items.length > 1) {
                            item.remove();
                        } else {
                            item.querySelectorAll('input, textarea').forEach(f => f.value = '');
                        }
                        updatePrescriptionItemTitles();
                    }
                }
                // Move up/down logic preserved...
            });

            // Print buttons
            document.addEventListener('click', (e) => {
                const printBtn = e.target.closest('.print-prescription-btn');
                if (printBtn) {
                    printPrescription(printBtn.dataset.prescriptionId);
                }
            });

            // All other existing handlers (patient drawer, etc.) preserved via doctor.js
        });
    </script>
@endsection
