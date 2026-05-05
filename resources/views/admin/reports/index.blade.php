@extends('admin.layouts.app')
@section('title', 'Reports')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1><p class="text-sm text-gray-500 mt-1">Hospital performance overview</p></div>
        <form method="GET" class="flex gap-2">
            @foreach(['week'=>'This Week','month'=>'This Month','year'=>'This Year'] as $k=>$v)
                <a href="{{ route('admin.reports.index', ['period'=>$k]) }}" class="btn {{ $period===$k ? 'btn-primary' : 'btn-secondary' }} btn-sm">{{ $v }}</a>
            @endforeach
        </form>
    </div>
    {{-- KPI Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['New Patients', $stats['new_patients'], 'bg-blue-50', 'text-blue-600'],
            ['Appointments', $stats['appointments'], 'bg-violet-50', 'text-violet-600'],
            ['Revenue', '₹'.number_format($stats['revenue']), 'bg-emerald-50', 'text-emerald-600'],
            ['Admissions', $stats['admissions'], 'bg-amber-50', 'text-amber-600'],
        ] as [$label, $value, $bg, $color])
        <div class="kpi-card"><div class="kpi-icon {{ $bg }}"><span class="{{ $color }} text-lg font-bold">{{ is_numeric($value) ? $value : '' }}</span></div><div><p class="kpi-value">{{ $value }}</p><p class="kpi-label">{{ $label }}</p></div></div>
        @endforeach
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="admin-card">
            <h2 class="text-base font-semibold text-gray-900 mb-2">Additional Metrics</h2>
            <dl class="grid grid-cols-2 gap-4 mt-4">
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Completed Appts</dt><dd class="text-lg font-semibold text-gray-900 mt-1">{{ $stats['completed_appointments'] }}</dd></div>
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Discharges</dt><dd class="text-lg font-semibold text-gray-900 mt-1">{{ $stats['discharges'] }}</dd></div>
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Pending Dues</dt><dd class="text-lg font-semibold text-red-600 mt-1">₹{{ number_format($stats['pending_dues']) }}</dd></div>
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Completion Rate</dt><dd class="text-lg font-semibold text-gray-900 mt-1">{{ $stats['appointments'] > 0 ? round($stats['completed_appointments'] / $stats['appointments'] * 100) : 0 }}%</dd></div>
            </dl>
        </div>
        <div class="admin-card">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Top 5 Doctors</h2>
            @forelse($topDoctors as $doc)
            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <div class="flex items-center gap-3"><div class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($doc->name,0,1)) }}</div><div><p class="text-sm font-medium text-gray-900">{{ $doc->name }}</p><p class="text-xs text-gray-500">{{ $doc->specialization ?? '' }}</p></div></div>
                <span class="badge badge-gray">{{ $doc->appointments_count }} appts</span>
            </div>
            @empty<p class="text-sm text-gray-400">No data available.</p>@endforelse
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="admin-card">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Department Performance</h2>
            @forelse($deptStats as $ds)
            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <span class="text-sm text-gray-700">{{ $ds->department->name ?? 'Unassigned' }}</span>
                <span class="badge badge-gray">{{ $ds->total }} appointments</span>
            </div>
            @empty<p class="text-sm text-gray-400">No department data.</p>@endforelse
        </div>
        <div class="admin-card">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Low Stock Medicines</h2>
            @forelse($lowStock as $med)
            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <div><p class="text-sm font-medium text-gray-800">{{ $med->name }}</p><p class="text-xs text-gray-500">Reorder at {{ $med->reorder_level }}</p></div>
                <span class="badge badge-danger">{{ $med->stock_quantity }} left</span>
            </div>
            @empty<p class="text-sm text-gray-400 flex items-center gap-2"><svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>All medicines are well-stocked.</p>@endforelse
        </div>
    </div>
@endsection
