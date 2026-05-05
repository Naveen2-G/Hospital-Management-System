@extends('admin.layouts.app')
@section('title', $patient->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.patients.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Patients
        </a>
        <div class="flex items-center justify-between mt-2">
            <h1 class="text-2xl font-bold text-gray-900">{{ $patient->name }}</h1>
            <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-secondary btn-sm">Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card lg:col-span-2">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Patient Information</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach([
                    'Email' => $patient->email ?? '—',
                    'Phone' => $patient->phone ?? '—',
                    'Date of Birth' => $patient->dob ? $patient->dob->format('M d, Y') : '—',
                    'Gender' => $patient->gender ? ucfirst($patient->gender) : '—',
                    'Blood Group' => $patient->blood_group ?? '—',
                    'Emergency Contact' => ($patient->emergency_contact_name ?? '') . ' ' . ($patient->emergency_contact ?? '—'),
                ] as $label => $value)
                <div>
                    <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $label }}</dt>
                    <dd class="text-sm text-gray-800 mt-1">{{ $value }}</dd>
                </div>
                @endforeach
                <div class="sm:col-span-2">
                    <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Address</dt>
                    <dd class="text-sm text-gray-800 mt-1">{{ $patient->address ?? '—' }}</dd>
                </div>
            </dl>
        </div>

        <div class="space-y-6">
            <div class="admin-card text-center">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-3">{{ strtoupper(substr($patient->name, 0, 1)) }}</div>
                <h3 class="font-semibold text-gray-900">{{ $patient->name }}</h3>
                <p class="text-sm text-gray-500">Patient ID: #{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="text-xs text-gray-400 mt-1">Registered {{ $patient->created_at->format('M d, Y') }}</p>
            </div>
            <div class="admin-card">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Quick Stats</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Appointments</span><span class="font-medium">{{ $patient->appointments->count() }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Admissions</span><span class="font-medium">{{ $patient->admissions->count() }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Invoices</span><span class="font-medium">{{ $patient->invoices->count() }}</span></div>
                </div>
            </div>
        </div>
    </div>
@endsection
