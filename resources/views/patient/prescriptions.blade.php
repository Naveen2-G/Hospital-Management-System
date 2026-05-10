@extends('patient.layouts.app')

@section('title', 'Prescriptions')

@section('content')
    <section class="patient-card">
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
@endsection

