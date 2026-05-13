@extends('doctor.layouts.app')

@section('title', 'Doctor Profile')

@section('content')
<section class="patient-card" style="border-color:rgba(59,130,246,0.18);">
    
    <div class="patient-card-header">
        <h2 class="patient-card-title flex items-center gap-2">
            <div class="card-title-icon" style="background:linear-gradient(135deg,#0284c7,#2563eb);">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>

            Doctor Profile
        </h2>

        <p class="patient-card-subtitle">
            Manage your personal and professional information.
        </p>
    </div>

    @if(session('success'))
        <div class="patient-alert patient-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('doctor.profile.update') }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="profile-avatar-wrap">

            @if(isset($doctor->image) && $doctor->image)
                <img src="{{ Storage::url($doctor->image) }}"
                     alt="Doctor"
                     class="profile-avatar">
            @else
                <div class="profile-avatar-placeholder"
                     style="background:linear-gradient(135deg,#0284c7,#2563eb);">
                    {{ strtoupper(substr($doctor->name ?? 'D',0,1)) }}
                </div>
            @endif

            <div>
                <div style="font-weight:800;font-size:0.95rem;color:#0f172a;">
                    {{ $doctor->name }}
                </div>

                <div style="font-size:0.8rem;color:#64748b;margin-top:0.15rem;">
                    {{ $doctor->email }}
                </div>

                <div style="margin-top:0.4rem;">
                    <span class="patient-badge"
                          style="background:rgba(59,130,246,0.08);color:#1d4ed8;border-color:rgba(59,130,246,0.15);">
                        {{ $doctor->specialization ?? 'General Physician' }}
                    </span>
                </div>

                <label style="margin-top:0.6rem;display:inline-flex;align-items:center;gap:0.4rem;font-size:0.75rem;font-weight:700;color:#2563eb;cursor:pointer;">
    
    <span id="doctor-photo-text">Choose Photo</span>

    <input type="file"
           name="image"
           accept="image/*"
           style="display:none;"
           onchange="
                document.getElementById('doctor-photo-text').innerText =
                this.files[0] ? this.files[0].name : 'Choose Photo';
           ">
</label>
            </div>
        </div>

        <div class="profile-section-title"
             style="color:#2563eb;">
            Personal Information
        </div>

        <div class="profile-field-group">

            <div class="profile-field">
                <label>Full Name *</label>
                <input class="profile-input"
                       type="text"
                       name="name"
                       value="{{ old('name',$doctor->name ?? '') }}"
                       required>
            </div>

            <div class="profile-field">
                <label>Employee ID</label>
                <input class="profile-input"
                       type="text"
                       name="employee_id"
                       value="{{ old('employee_id',$doctor->employee_id ?? '') }}">
            </div>

            <div class="profile-field">
                <label>Phone</label>
                <input class="profile-input"
                       type="text"
                       name="phone"
                       value="{{ old('phone',$doctor->phone ?? '') }}">
            </div>

            <div class="profile-field">
                <label>Email</label>
                <input class="profile-input"
                       type="email"
                       name="email"
                       value="{{ old('email',$doctor->email ?? '') }}">
            </div>

            <div class="profile-field">
                <label>Gender</label>

                <select class="profile-input" name="gender">
                    <option value="">Select</option>

                    <option value="male"
                        {{ old('gender',$doctor->gender ?? '') == 'male' ? 'selected' : '' }}>
                        Male
                    </option>

                    <option value="female"
                        {{ old('gender',$doctor->gender ?? '') == 'female' ? 'selected' : '' }}>
                        Female
                    </option>

                    <option value="other"
                        {{ old('gender',$doctor->gender ?? '') == 'other' ? 'selected' : '' }}>
                        Other
                    </option>
                </select>
            </div>

            <div class="profile-field">
                <label>Date of Birth</label>

                <input class="profile-input"
                       type="date"
                       name="dob"
                       value="{{ old('dob',$doctor?->dob?->format('Y-m-d')) }}">
            </div>

            <div class="profile-field">
                <label>Blood Group</label>

                <select class="profile-input" name="blood_group">
                    <option value="">Select</option>

                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                        <option value="{{ $bg }}"
                            {{ old('blood_group',$doctor->blood_group ?? '') == $bg ? 'selected' : '' }}>
                            {{ $bg }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="profile-field">
                <label>Joining Date</label>

                <input class="profile-input"
                       type="date"
                       name="joining_date"
                       value="{{ old('joining_date',$doctor?->joining_date?->format('Y-m-d')) }}">
            </div>

            <div class="profile-field"
                 style="grid-column:1/-1;">
                <label>Address</label>

                <textarea class="profile-input"
                          rows="3"
                          name="address">{{ old('address',$doctor->address ?? '') }}</textarea>
            </div>
        </div>

        <div class="profile-section-title"
             style="color:#2563eb;">
            Professional Information
        </div>

        <div class="profile-field-group">

            <div class="profile-field">
                <label>Specialization</label>

                <input class="profile-input"
                       type="text"
                       name="specialization"
                       value="{{ old('specialization',$doctor->specialization ?? '') }}">
            </div>

            <div class="profile-field">
                <label>Qualification</label>

                <input class="profile-input"
                       type="text"
                       name="qualification"
                       value="{{ old('qualification',$doctor->qualification ?? '') }}">
            </div>

            <div class="profile-field">
                <label>Experience (Years)</label>

                <input class="profile-input"
                       type="number"
                       name="experience_years"
                       value="{{ old('experience_years',$doctor->experience_years ?? '') }}">
            </div>

            <div class="profile-field">
                <label>Consultation Fee (₹)</label>

                <input class="profile-input"
                       type="number"
                       step="0.01"
                       name="consultation_fee"
                       value="{{ old('consultation_fee',$doctor->consultation_fee ?? '') }}">
            </div>

            <div class="profile-field"
                 style="grid-column:1/-1;">
                <label>Bio</label>

                <textarea class="profile-input"
                          rows="4"
                          name="bio">{{ old('bio',$doctor->bio ?? '') }}</textarea>
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;gap:0.75rem;flex-wrap:wrap;">

            <button type="submit"
                    class="patient-pill patient-pill-dark"
                    style="background:linear-gradient(135deg,#0284c7,#2563eb);border:none;">

                Save Profile
            </button>

            <button type="button"
        data-doctor-password-open
        class="patient-pill">
    Change Password
</button>

        </div>
    </form>
</section>
@endsection