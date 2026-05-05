@extends('admin.layouts.app')
@section('title', isset($patient) ? 'Edit Patient' : 'Add Patient')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.patients.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Patients
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($patient) ? 'Edit Patient' : 'Add New Patient' }}</h1>
    </div>

    <div class="admin-card max-w-3xl">
        <form method="POST" action="{{ isset($patient) ? route('admin.patients.update', $patient) : route('admin.patients.store') }}">
            @csrf
            @if(isset($patient)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group">
                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $patient->name ?? '') }}" class="form-input" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}" class="form-input">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}" class="form-input" required>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob', isset($patient) && $patient->dob ? $patient->dob->format('Y-m-d') : '') }}" class="form-input">
                    @error('dob') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-input">
                        <option value="">Select</option>
                        @foreach(['male','female','other'] as $g)
                            <option value="{{ $g }}" {{ old('gender', $patient->gender ?? '') === $g ? 'selected' : '' }}>{{ ucfirst($g) }}</option>
                        @endforeach
                    </select>
                    @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Blood Group</label>
                    <select name="blood_group" class="form-input">
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                            <option value="{{ $bg }}" {{ old('blood_group', $patient->blood_group ?? '') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                        @endforeach
                    </select>
                    @error('blood_group') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group md:col-span-2">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="2" class="form-input">{{ old('address', $patient->address ?? '') }}</textarea>
                    @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name ?? '') }}" class="form-input">
                    @error('emergency_contact_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Emergency Contact Phone</label>
                    <input type="text" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact ?? '') }}" class="form-input">
                    @error('emergency_contact') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary">{{ isset($patient) ? 'Update Patient' : 'Add Patient' }}</button>
                <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
