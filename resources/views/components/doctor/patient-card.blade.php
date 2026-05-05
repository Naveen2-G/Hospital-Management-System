@props([
    'patient',
    'patientHistory' => [],
    'patientTimeline' => [],
])

<div class="group rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    {{-- Patient Header --}}
    <div class="mb-4 flex items-start justify-between gap-3">
        <div class="flex-1">
            <h3 class="font-semibold text-slate-900">{{ $patient->name ?? 'Unknown Patient' }}</h3>
            <p class="text-xs text-slate-500">ID: {{ $patient->patient_id ?? 'N/A' }}</p>
        </div>
        <div class="rounded-full bg-blue-100 p-2 text-blue-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
    </div>

    {{-- Patient Info Grid --}}
    <div class="mb-4 grid grid-cols-2 gap-3 text-sm">
        {{-- Age & Gender --}}
        <div>
            <p class="text-xs font-medium text-slate-500">Age</p>
            <p class="text-slate-900">
                @if ($patient->date_of_birth)
                    {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} yrs
                @else
                    N/A
                @endif
            </p>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-500">Gender</p>
            <p class="text-slate-900">{{ ucfirst($patient->gender ?? 'N/A') }}</p>
        </div>

        {{-- Contact --}}
        <div class="col-span-2">
            <p class="text-xs font-medium text-slate-500">Phone</p>
            <p class="text-slate-900">{{ $patient->phone ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Recent Activity --}}
    @if (!empty($patientTimeline))
        <div class="border-t border-slate-100 pt-3">
            <p class="text-xs font-semibold text-slate-600 mb-2">Recent</p>
            <p class="text-xs text-slate-500">
                {{ $patientTimeline[0]['description'] ?? 'No recent activity' }}
            </p>
        </div>
    @else
        <div class="border-t border-slate-100 pt-3">
            <p class="text-xs text-slate-500">No recent activity</p>
        </div>
    @endif

    {{-- Action Link --}}
    <div class="mt-3">
        <button type="button" 
                class="w-full rounded-lg bg-blue-50 px-3 py-2 text-center text-xs font-semibold text-blue-600 transition hover:bg-blue-100 open-patient-drawer"
                data-patient-name="{{ $patient->name ?? 'Unknown' }}"
                data-patient-phone="{{ $patient->phone ?? '—' }}"
                data-patient-email="{{ $patient->email ?? '—' }}"
                data-patient-gender="{{ ucfirst($patient->gender ?? '—') }}"
                data-patient-blood-group="{{ $patient->blood_group ?? '—' }}"
                data-patient-dob="{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : '—' }}"
                data-patient-address="{{ $patient->address ?? '—' }}"
                data-patient-emergency="{{ $patient->emergency_contact ?? '—' }}"
                data-patient-visits="0">
            View Full Profile
        </button>
    </div>
</div>
