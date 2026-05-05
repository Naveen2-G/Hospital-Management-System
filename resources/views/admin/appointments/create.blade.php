@extends('admin.layouts.app')
@section('title', isset($appointment) ? 'Edit Appointment' : 'New Appointment')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Appointments
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($appointment) ? 'Edit Appointment' : 'New Appointment' }}</h1>
    </div>
    <div class="admin-card max-w-3xl">
        <form method="POST" action="{{ isset($appointment) ? route('admin.appointments.update', $appointment) : route('admin.appointments.store') }}">
            @csrf
            @if(isset($appointment)) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Patient *</label>
                    <select name="patient_id" class="form-input" required><option value="">Select Patient</option>
                        @foreach($patients as $p)<option value="{{ $p->id }}" {{ old('patient_id', $appointment->patient_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Doctor *</label>
                    <select name="doctor_id" class="form-input" required><option value="">Select Doctor</option>
                        @foreach($doctors as $d)<option value="{{ $d->id }}" {{ old('doctor_id', $appointment->doctor_id ?? '') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Department</label>
                    <select name="department_id" class="form-input"><option value="">Select</option>
                        @foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id', $appointment->department_id ?? '') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Type</label>
                    <select name="type" class="form-input">
                        @foreach(['regular','emergency','video'] as $t)<option value="{{ $t }}" {{ old('type', $appointment->type ?? 'regular') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Date *</label><input type="date" name="appointment_date" value="{{ old('appointment_date', isset($appointment) ? $appointment->appointment_date->format('Y-m-d') : '') }}" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Time Slot *</label>
                    <select name="time_slot" class="form-input" required><option value="">Select</option>
                        @foreach(['09:00 - 09:30','09:30 - 10:00','10:00 - 10:30','10:30 - 11:00','11:00 - 11:30','11:30 - 12:00','14:00 - 14:30','14:30 - 15:00','15:00 - 15:30','15:30 - 16:00'] as $slot)
                            <option value="{{ $slot }}" {{ old('time_slot', $appointment->time_slot ?? '') === $slot ? 'selected' : '' }}>{{ $slot }}</option>
                        @endforeach
                    </select>
                </div>
                @if(isset($appointment))
                <div class="form-group"><label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        @foreach(['pending','confirmed','completed','cancelled'] as $s)<option value="{{ $s }}" {{ $appointment->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach
                    </select>
                </div>
                @endif
                <div class="form-group md:col-span-2"><label class="form-label">Notes</label><textarea name="notes" rows="2" class="form-input">{{ old('notes', $appointment->notes ?? '') }}</textarea></div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary">{{ isset($appointment) ? 'Update' : 'Create Appointment' }}</button>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
