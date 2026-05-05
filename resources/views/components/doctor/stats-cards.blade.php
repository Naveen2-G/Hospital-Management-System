@props(['stats' => []])

<div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Today's Appointments -->
    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Today</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['today_appointments'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl bg-sky-50 p-3 text-sky-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-slate-500">appointments today</p>
    </div>

    <!-- Upcoming Appointments -->
    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Upcoming</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['upcoming_appointments'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl bg-blue-50 p-3 text-blue-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-slate-500">pending appointments</p>
    </div>

    <!-- Patients Handled -->
    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Patients</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['patients_handled'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM16 20a3 3 0 00-3-3H5a3 3 0 00-3 3v2h14v-2z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-slate-500">total patients handled</p>
    </div>

    <!-- Completion Rate -->
    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Rate</p>
                <p class="mt-2 text-3xl font-black text-slate-900">{{ $stats['completion_rate'] ?? 0 }}%</p>
            </div>
            <div class="rounded-2xl bg-amber-50 p-3 text-amber-700">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        <p class="mt-3 text-xs text-slate-500">completion rate</p>
    </div>
</div>
