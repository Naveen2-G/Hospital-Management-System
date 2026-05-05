@extends('admin.layouts.app')
@section('title', 'Admission Details')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.admissions.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <div class="flex items-center justify-between mt-2">
            <h1 class="text-2xl font-bold text-gray-900">Admission #{{ $admission->id }}</h1>
            <a href="{{ route('admin.admissions.edit', $admission) }}" class="btn btn-secondary btn-sm">Edit</a>
        </div>
    </div>
    <div class="admin-card max-w-3xl">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Patient</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->patient->name ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Doctor</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->doctor->name ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Type</dt><dd class="mt-1"><span class="badge {{ $admission->type==='IPD'?'badge-info':'badge-gray' }}">{{ $admission->type }}</span></dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Status</dt><dd class="mt-1">@php $bm=['admitted'=>'badge-warning','discharged'=>'badge-success','transferred'=>'badge-info']; @endphp<span class="badge {{ $bm[$admission->status]??'badge-gray' }}">{{ ucfirst($admission->status) }}</span></dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Bed</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->bed ? $admission->bed->bed_number : '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Admission Date</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->admission_date->format('M d, Y') }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Discharge Date</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->discharge_date ? $admission->discharge_date->format('M d, Y') : '—' }}</dd></div>
            @if($admission->diagnosis)<div class="sm:col-span-2"><dt class="text-xs font-medium text-gray-400 uppercase">Diagnosis</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->diagnosis }}</dd></div>@endif
            @if($admission->notes)<div class="sm:col-span-2"><dt class="text-xs font-medium text-gray-400 uppercase">Notes</dt><dd class="text-sm text-gray-800 mt-1">{{ $admission->notes }}</dd></div>@endif
        </dl>
    </div>
@endsection
