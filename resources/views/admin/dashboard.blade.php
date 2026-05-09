@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Welcome back, {{ \Illuminate\Support\Facades\Auth::user()->name ?? '' }}. Here's what's happening today.</p>
        </div>
        <div class="hidden sm:flex items-center gap-4">
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary btn-sm">New Patient</a>
                <a href="{{ route('admin.appointments.create') }}" class="btn btn-secondary btn-sm">New Appointment</a>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                {{ now()->format('l, M d, Y') }}
            </div>
        </div>
    </div>

    {{-- ═══ KPI Cards ═════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Total Patients --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-blue-50">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($stats['total_patients']) }}</p>
                <p class="kpi-label">Total Patients</p>
            </div>
        </div>

        {{-- Total Doctors --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-emerald-50">
                <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($stats['total_doctors']) }}</p>
                <p class="kpi-label">Active Doctors</p>
            </div>
        </div>

        {{-- Today's Appointments --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-violet-50">
                <svg class="w-6 h-6 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($stats['today_appointments']) }}</p>
                <p class="kpi-label">Today's Appointments</p>
            </div>
        </div>

        {{-- Monthly Revenue --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-amber-50">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="kpi-value">₹{{ number_format($stats['monthly_revenue']) }}</p>
                <p class="kpi-label">Monthly Revenue</p>
            </div>
        </div>

        {{-- Active Admissions --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-rose-50">
                <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            </div>
            <div>
                <p class="kpi-value">{{ number_format($stats['active_admissions']) }}</p>
                <p class="kpi-label">Active Admissions</p>
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="kpi-card">
            <div class="kpi-icon bg-red-50">
                <svg class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="kpi-value">₹{{ number_format($stats['pending_payments']) }}</p>
                <p class="kpi-label">Pending Dues</p>
            </div>
        </div>
    </div>

    {{-- ═══ Charts Row ════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Revenue Chart --}}
        <div class="admin-card lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-900">Revenue — Last 7 Days</h2>
                <span class="badge badge-info">₹{{ number_format(collect($revenueChart)->sum('amount')) }} total</span>
            </div>
            <div class="chart-container">
                <canvas id="revenue-chart" data-chart='@json($revenueChart)'></canvas>
            </div>
        </div>

        {{-- Appointment Distribution --}}
        <div class="admin-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-900">Appointments</h2>
                <span class="badge badge-gray">{{ array_sum($appointmentStats) }} total</span>
            </div>
            <div class="chart-container">
                <canvas id="appointment-chart" data-chart='@json($appointmentStats)'></canvas>
            </div>
        </div>
    </div>

    {{-- ═══ Bottom Section ════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Appointments --}}
        <div class="admin-card lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-900">Recent Appointments</h2>
                <a href="{{ route('admin.appointments.index') }}" class="text-sm text-primary-600 font-medium hover:underline">View all →</a>
            </div>

            @if($recentAppointments->isEmpty())
                <div class="empty-state">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/></svg>
                    <p class="text-sm">No appointments yet</p>
                </div>
            @else
                <div class="overflow-x-auto -mx-6">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th class="pl-6">Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAppointments as $apt)
                            <tr>
                                <td class="pl-6 font-medium text-gray-900">
                                    {{ $apt->patient_name }}
                                    @if(!$apt->patient_id)
                                        <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[0.65rem] font-medium bg-amber-100 text-amber-800">Guest</span>
                                    @endif
                                </td>
                                <td>{{ $apt->doctor->name ?? '—' }}</td>
                                <td>{{ $apt->appointment_date->format('M d, Y') }}</td>
                                <td>{{ $apt->time_slot }}</td>
                                <td>
                                    @php
                                        $badgeMap = ['pending'=>'badge-warning','confirmed'=>'badge-info','completed'=>'badge-success','cancelled'=>'badge-danger'];
                                    @endphp
                                    <span class="badge {{ $badgeMap[$apt->status] ?? 'badge-gray' }}">{{ ucfirst($apt->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Quick Info Panel --}}
        <div class="space-y-6">
            {{-- Room Occupancy --}}
            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Room Occupancy</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Rooms</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $roomStats['total'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Available</span>
                        <span class="badge badge-success">{{ $roomStats['available'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Occupied</span>
                        <span class="badge badge-warning">{{ $roomStats['occupied'] }}</span>
                    </div>
                    @if($roomStats['total'] > 0)
                    <div class="pt-2">
                        @php
                            $percent = ($roomStats['available'] / max($roomStats['total'], 1)) * 100;
                        @endphp
                        <progress
                            class="w-full h-2 overflow-hidden rounded-full bg-gray-100 [&::-webkit-progress-bar]:bg-gray-100 [&::-webkit-progress-value]:bg-emerald-500 [&::-moz-progress-bar]:bg-emerald-500"
                            value="{{ round($percent) }}"
                            max="100"
                        ></progress>
                        <p class="text-xs text-gray-400 mt-1.5">{{ round($percent) }}% available</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Low Stock Medicines --}}
            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Low Stock Alert</h2>
                @if($lowStockMedicines->isEmpty())
                    <p class="text-sm text-gray-400">All medicine stocks are healthy.</p>
                @else
                    <div class="space-y-3">
                        @foreach($lowStockMedicines as $med)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $med->name }}</p>
                                <p class="text-xs text-gray-400">Reorder at {{ $med->reorder_level }}</p>
                            </div>
                            <span class="badge badge-danger">{{ $med->stock_quantity }} left</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent Activity --}}
            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Recent Activity</h2>
                @if($recentActivity->isEmpty())
                    <p class="text-sm text-gray-400">No recent activity.</p>
                @else
                    <div class="space-y-0">
                        @foreach($recentActivity->take(5) as $log)
                        <div class="activity-item">
                            <div class="activity-dot {{ $log->action === 'login' ? 'bg-emerald-400' : ($log->action === 'logout' ? 'bg-gray-400' : 'bg-primary-400') }}"></div>
                            <div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">{{ $log->user->name ?? 'System' }}</span>
                                    {{ $log->action }}
                                    @if($log->model_type) {{ class_basename($log->model_type) }} @endif
                                </p>
                                <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
