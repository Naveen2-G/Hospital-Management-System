@props(['stats', 'kpis' => null])

@php
    if (!$kpis) {
        $kpis = [
            ['label' => 'Today appointments', 'value' => $stats['today_appointments'], 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'tone' => 'from-sky-50 to-blue-50 text-sky-700'],
            ['label' => 'Upcoming', 'value' => $stats['upcoming_appointments'], 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'tone' => 'from-cyan-50 to-sky-50 text-cyan-700'],
            ['label' => 'Patients handled', 'value' => $stats['patients_handled'], 'icon' => 'M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H6m11 0v-2c0-1.1-.4-2.1-1-2.9M6 20H1v-2a4 4 0 014-4h1m0 6v-2c0-1.1.4-2.1 1-2.9m0 0a5 5 0 019 0M12 11a5 5 0 100-10 5 5 0 000 10z', 'tone' => 'from-emerald-50 to-teal-50 text-emerald-700'],
            ['label' => 'Pending consults', 'value' => $stats['pending_consultations'], 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'tone' => 'from-amber-50 to-orange-50 text-amber-700'],
            ['label' => 'Labs requested', 'value' => $stats['lab_requests'], 'icon' => 'M9 3h6m-5 0v4m4-4v4m-6 6h6M6 7h12v12H6z', 'tone' => 'from-violet-50 to-fuchsia-50 text-violet-700'],
            ['label' => 'Unread alerts', 'value' => $stats['unread_notifications'], 'icon' => 'M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31', 'tone' => 'from-rose-50 to-red-50 text-rose-700'],
        ];
    }
@endphp

<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-3">
    @foreach($kpis as $kpi)
        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
            <div class="flex items-start justify-between gap-3">
                <div class="inline-flex rounded-2xl bg-linear-to-r {{ $kpi['tone'] }} px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em]">
                    {{ $kpi['label'] }}
                </div>
                <div class="rounded-2xl bg-slate-50 p-2 text-slate-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $kpi['icon'] }}"/>
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-black text-slate-900">{{ $kpi['value'] }}</p>
            <p class="mt-1 text-sm text-slate-500">Backend-ready metric</p>
        </div>
    @endforeach
</div>

