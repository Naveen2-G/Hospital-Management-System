@props(['patient', 'patientHistory' => null, 'patientTimeline' => null])

<div class="group rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
    <div class="flex items-start justify-between gap-3">
        <div class="flex items-start gap-3">
            <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-sky-50 text-sky-700">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0115 0"/>
                </svg>
            </span>
            <div>
                <h4 class="text-lg font-bold text-slate-900">{{ $patient->name }}</h4>
                <p class="text-sm text-slate-500">{{ $patient->phone ?? 'No phone' }}</p>
            </div>
        </div>
        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $patient->visits_count }} visits</span>
    </div>
    <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
        <div>
            <dt class="text-slate-400">Blood group</dt>
            <dd class="font-semibold text-slate-900">{{ $patient->blood_group ?? '—' }}</dd>
        </div>
        <div>
            <dt class="text-slate-400">Gender</dt>
            <dd class="font-semibold text-slate-900">{{ $patient->gender ?? '—' }}</dd>
        </div>
        <div class="col-span-2">
            <dt class="text-slate-400">DOB</dt>
            <dd class="font-semibold text-slate-900">{{ $patient->dob?->format('M d, Y') ?? '—' }}</dd>
        </div>
    </dl>
    <div class="mt-4 flex flex-wrap gap-2">
        <button type="button" class="open-patient-drawer rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white" data-patient-name="{{ $patient->name }}" data-patient-phone="{{ $patient->phone ?? '—' }}" data-patient-email="{{ $patient->email ?? '—' }}" data-patient-gender="{{ $patient->gender ?? '—' }}" data-patient-blood-group="{{ $patient->blood_group ?? '—' }}" data-patient-dob="{{ $patient->dob?->format('M d, Y') ?? '—' }}" data-patient-address="{{ $patient->address ?? '—' }}" data-patient-emergency="{{ $patient->emergency_contact_name ? $patient->emergency_contact_name . ' · ' . $patient->emergency_contact : '—' }}" data-patient-visits="{{ $patient->visits_count }}" data-patient-history="{{ base64_encode(json_encode($patientHistory[$patient->id] ?? [])) }}" data-patient-timeline="{{ base64_encode(json_encode($patientTimeline[$patient->id] ?? [])) }}">Open EMR</button>
        <button type="button" class="open-patient-drawer rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700" data-patient-name="{{ $patient->name }}" data-patient-phone="{{ $patient->phone ?? '—' }}" data-patient-email="{{ $patient->email ?? '—' }}" data-patient-gender="{{ $patient->gender ?? '—' }}" data-patient-blood-group="{{ $patient->blood_group ?? '—' }}" data-patient-dob="{{ $patient->dob?->format('M d, Y') ?? '—' }}" data-patient-address="{{ $patient->address ?? '—' }}" data-patient-emergency="{{ $patient->emergency_contact_name ? $patient->emergency_contact_name . ' · ' . $patient->emergency_contact : '—' }}" data-patient-visits="{{ $patient->visits_count }}" data-patient-history="{{ base64_encode(json_encode($patientHistory[$patient->id] ?? [])) }}" data-patient-timeline="{{ base64_encode(json_encode($patientTimeline[$patient->id] ?? [])) }}">History</button>
    </div>
</div>

