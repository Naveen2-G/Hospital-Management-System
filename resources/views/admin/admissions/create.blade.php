@extends('admin.layouts.app')
@section('title', isset($admission) ? 'Edit Admission' : 'New Admission')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.admissions.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back to Admissions</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($admission) ? 'Edit Admission' : 'New Admission' }}</h1>
    </div>
    <div class="admin-card max-w-3xl">
        <form method="POST" action="{{ isset($admission) ? route('admin.admissions.update', $admission) : route('admin.admissions.store') }}">
            @csrf
            @if(isset($admission)) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Patient *</label>
                    <select name="patient_id" class="form-input" required><option value="">Select</option>@foreach($patients as $p)<option value="{{ $p->id }}" {{ old('patient_id', $admission->patient_id ?? '')==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach</select>
                    @error('patient_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="form-group"><label class="form-label">Doctor *</label>
                    <select name="doctor_id" class="form-input" required><option value="">Select</option>@foreach($doctors as $d)<option value="{{ $d->id }}" {{ old('doctor_id', $admission->doctor_id ?? '')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select>
                </div>
                <div class="form-group"><label class="form-label">Type *</label>
                    <select name="type" class="form-input" required>
                        <option value="OPD" {{ old('type', $admission->type ?? 'OPD')==='OPD'?'selected':'' }}>OPD</option>
                        <option value="IPD" {{ old('type', $admission->type ?? '')==='IPD'?'selected':'' }}>IPD</option>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Bed (for IPD)</label>
                    <select name="bed_id" class="form-input"><option value="">No Bed</option>@foreach($beds as $b)<option value="{{ $b->id }}" {{ old('bed_id', $admission->bed_id ?? '')==$b->id?'selected':'' }}>{{ $b->bed_number }} (Room {{ $b->room->room_number }} - {{ $b->room->type }})</option>@endforeach</select>
                </div>
                <div class="form-group"><label class="form-label">Admission Date *</label><input type="date" name="admission_date" value="{{ old('admission_date', isset($admission) ? $admission->admission_date->format('Y-m-d') : date('Y-m-d')) }}" class="form-input" required></div>
                @if(isset($admission))
                <div class="form-group"><label class="form-label">Discharge Date</label><input type="date" name="discharge_date" value="{{ old('discharge_date', $admission->discharge_date ? $admission->discharge_date->format('Y-m-d') : '') }}" class="form-input"></div>
                <div class="form-group"><label class="form-label">Status</label>
                    <select name="status" class="form-input">@foreach(['admitted','discharged','transferred'] as $s)<option value="{{ $s }}" {{ $admission->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select>
                </div>
                @endif
                <div class="form-group md:col-span-2"><label class="form-label">Diagnosis</label><textarea name="diagnosis" rows="2" class="form-input">{{ old('diagnosis', $admission->diagnosis ?? '') }}</textarea></div>
                <div class="form-group md:col-span-2"><label class="form-label">Notes</label><textarea name="notes" rows="2" class="form-input">{{ old('notes', $admission->notes ?? '') }}</textarea></div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary">{{ isset($admission) ? 'Update' : 'Record Admission' }}</button>
                <a href="{{ route('admin.admissions.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
