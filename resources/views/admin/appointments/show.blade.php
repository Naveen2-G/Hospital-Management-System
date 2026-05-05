@extends('admin.layouts.app')
@section('title', 'Appointment Details')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Appointments
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Appointment #{{ $appointment->id }}</h1>
    </div>
    <div class="admin-card max-w-3xl">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Patient</dt><dd class="text-sm text-gray-800 mt-1">{{ $appointment->patient->name ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Doctor</dt><dd class="text-sm text-gray-800 mt-1">{{ $appointment->doctor->name ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Department</dt><dd class="text-sm text-gray-800 mt-1">{{ $appointment->department->name ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Type</dt><dd class="text-sm text-gray-800 mt-1">{{ ucfirst($appointment->type) }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Date</dt><dd class="text-sm text-gray-800 mt-1">{{ $appointment->appointment_date->format('M d, Y') }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Time</dt><dd class="text-sm text-gray-800 mt-1">{{ $appointment->time_slot }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Status</dt><dd class="mt-1">
                @php $bm=['pending'=>'badge-warning','confirmed'=>'badge-info','completed'=>'badge-success','cancelled'=>'badge-danger']; @endphp
                <span class="badge {{ $bm[$appointment->status] ?? 'badge-gray' }}">{{ ucfirst($appointment->status) }}</span>
            </dd></div>
            @if($appointment->notes)
            <div class="sm:col-span-2"><dt class="text-xs font-medium text-gray-400 uppercase">Notes</dt><dd class="text-sm text-gray-800 mt-1">{{ $appointment->notes }}</dd></div>
            @endif
        </dl>
    </div>
@endsection
