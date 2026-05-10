@extends('patient.layouts.app')

@section('title', 'Profile')

@section('content')
    <section class="patient-card">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
                My Profile
            </h2>
            <p class="patient-card-subtitle">Update your personal and medical information.</p>
        </div>

        <form method="POST" action="{{ route('patient.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="profile-avatar-wrap">
                @if(isset($patient->avatar) && $patient->avatar)
                    <img src="{{ asset('storage/'.$patient->avatar) }}" alt="Avatar" class="profile-avatar">
                @else
                    <div class="profile-avatar-placeholder">{{ strtoupper(substr($patient->name ?? 'P', 0, 1)) }}</div>
                @endif
                <div>
                    <div style="font-weight:800;font-size:0.95rem;color:#0f172a;">{{ $patient->name }}</div>
                    <div style="font-size:0.8rem;color:#64748b;margin-top:0.15rem;">{{ $user->email }}</div>
                    <label style="margin-top:0.6rem;display:inline-flex;align-items:center;gap:0.4rem;font-size:0.75rem;font-weight:700;color:#10b981;cursor:pointer;">
                        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        Change Photo
                        <input type="file" name="avatar" accept="image/*" style="display:none;" onchange="this.parentNode.querySelector('span').textContent=this.files[0]?.name??''">
                        <span style="color:#94a3b8;font-weight:500;"></span>
                    </label>
                </div>
            </div>

            <div class="profile-section-title">Personal Information</div>
            <div class="profile-field-group">
                <div class="profile-field">
                    <label>Full Name *</label>
                    <input class="profile-input" type="text" name="name" value="{{ old('name', $patient->name) }}" required>
                </div>
                <div class="profile-field">
                    <label>Phone</label>
                    <input class="profile-input" type="text" name="phone" value="{{ old('phone', $patient->phone) }}">
                </div>
                <div class="profile-field">
                    <label>Date of Birth</label>
                    <input class="profile-input" type="date" name="dob" value="{{ old('dob', $patient->dob?->format('Y-m-d')) }}">
                </div>
                <div class="profile-field">
                    <label>Gender</label>
                    <select class="profile-input" name="gender">
                        <option value="">Select</option>
                        <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="profile-field" style="grid-column:1/-1">
                    <label>Address</label>
                    <textarea class="profile-input" name="address" rows="2">{{ old('address', $patient->address) }}</textarea>
                </div>
            </div>

            <div class="profile-section-title">Medical Information</div>
            <div class="profile-field-group">
                <div class="profile-field">
                    <label>Blood Group</label>
                    <select class="profile-input" name="blood_group">
                        <option value="">Select</option>
                        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg_opt)
                            <option value="{{ $bg_opt }}" {{ old('blood_group', $patient->blood_group ?? '') === $bg_opt ? 'selected' : '' }}>{{ $bg_opt }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="profile-field">
                    <label>Allergies</label>
                    <input class="profile-input" type="text" name="allergies" value="{{ old('allergies', $patient->allergies ?? '') }}" placeholder="e.g. Penicillin, Dust">
                </div>
                <div class="profile-field" style="grid-column:1/-1">
                    <label>Chronic Diseases</label>
                    <input class="profile-input" type="text" name="chronic_diseases" value="{{ old('chronic_diseases', $patient->chronic_diseases ?? '') }}" placeholder="e.g. Diabetes, Hypertension">
                </div>
            </div>

            <div class="profile-section-title">Emergency Contact</div>
            <div class="profile-field-group">
                <div class="profile-field">
                    <label>Contact Name</label>
                    <input class="profile-input" type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" placeholder="e.g. Rahul Kumar">
                </div>
                <div class="profile-field">
                    <label>Contact Phone</label>
                    <input class="profile-input" type="text" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}" placeholder="e.g. +91 98765 43210">
                </div>
            </div>

            <div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;">
                <button type="submit" class="patient-pill patient-pill-dark">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Save Profile
                </button>
                <a href="{{ route('patient.change-password.edit') }}" class="patient-pill">
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                    Change Password
                </a>
            </div>
        </form>
    </section>
@endsection

