@extends('patient.layouts.app')

@section('title', 'Appointments')

@section('content')
    <div class="patient-card mb-5">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                Appointments
            </h2>
            <p class="patient-card-subtitle">Book and track your recent and upcoming visits.</p>
        </div>

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
    </div>

    @if($appointments->isEmpty())
        <div class="patient-empty">No appointments found yet.</div>
    @else
        <div class="patient-card overflow-x-auto">
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
@endsection

