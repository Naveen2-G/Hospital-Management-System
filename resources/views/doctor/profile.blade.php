@extends('doctor.layouts.app')

@section('title', 'Doctor Profile')

@section('content')
    @php
        $doctorName = $doctor?->name ?? 'Doctor';
        $doctorDepartment = $doctor?->department?->name ?? 'Core care team';
        $doctorSpecialization = $doctor?->specialization ?? 'General Practice';
        $doctorQualification = $doctor?->qualification ?? 'Clinical Practitioner';
        $experienceYears = $doctor?->experience_years ?? 0;
        $consultationFee = $doctor?->consultation_fee !== null ? number_format((float) $doctor->consultation_fee, 2) : null;
        $availability = is_array($doctor?->availability) ? $doctor->availability : [];
        $availabilityLabels = [
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',
        ];
        $availabilitySummary = [];
        foreach ($availabilityLabels as $key => $label) {
            if (! empty($availability[$key]) && is_array($availability[$key])) {
                $availabilitySummary[] = [
                    'day' => $label,
                    'slots' => $availability[$key],
                ];
            }
        }
        $personalCards = [
            ['label' => 'Phone Number', 'value' => old('phone', $doctor?->phone ?? $doctor?->user?->phone ?? '—')],
            ['label' => 'Email', 'value' => old('email', $doctor?->email ?? $doctor?->user?->email ?? '—')],
            ['label' => 'Gender', 'value' => old('gender', $doctor?->gender ? ucfirst($doctor->gender) : '—')],
            ['label' => 'Date of Birth', 'value' => old('dob', $doctor?->dob?->format('d M, Y') ?? '—')],
            ['label' => 'Blood Group', 'value' => old('blood_group', $doctor?->blood_group ?? '—')],
            ['label' => 'Employee ID', 'value' => old('employee_id', $doctor?->employee_id ?? '—')],
            ['label' => 'Joining Date', 'value' => old('joining_date', $doctor?->joining_date?->format('d M, Y') ?? '—')],
        ];
    @endphp

    <div class="space-y-8">
        @if(session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <section class="overflow-hidden rounded-4xl border border-slate-200 bg-white shadow-[0_24px_80px_rgba(15,23,42,0.10)]">
            <div class="grid gap-0 lg:grid-cols-[1.05fr_0.95fr]">
                <div class="relative overflow-hidden bg-linear-to-br from-sky-500 via-blue-600 to-slate-950 p-6 sm:p-8 text-white">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(125,211,252,0.32),transparent_28%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.15),transparent_24%)]"></div>
                    <div class="relative">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-cyan-200">Profile</p>
                        <h2 class="mt-2 text-4xl font-black tracking-tight">{{ $doctorName }}</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-100">
                            Manage your personal information, identity details, and availability from one place.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold">{{ $doctorSpecialization }}</span>
                            <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold">{{ $doctorDepartment }}</span>
                            <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-sm font-semibold">{{ $doctorQualification }}</span>
                        </div>

                        <div class="mt-8 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-3xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-cyan-100">Experience</p>
                                <p class="mt-2 text-2xl font-black">{{ $experienceYears }} yrs</p>
                            </div>
                            <div class="rounded-3xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-cyan-100">Fee</p>
                                <p class="mt-2 text-2xl font-black">{{ $consultationFee ? '₹'.$consultationFee : '—' }}</p>
                            </div>
                            <div class="rounded-3xl border border-white/15 bg-white/10 p-4 backdrop-blur-sm">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-cyan-100">Status</p>
                                <p class="mt-2 text-2xl font-black">{{ ucfirst($doctor?->status ?? 'active') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 p-6 sm:p-8">
                    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach($personalCards as $card)
                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">{{ $card['label'] }}</p>
                                <p class="mt-2 text-sm font-semibold text-slate-900">{{ $card['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[1fr_380px]">
            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Edit Profile</p>
                        <h3 class="text-2xl font-bold text-slate-900">Update personal information</h3>
                    </div>
                    <span class="rounded-full bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700">Save changes</span>
                </div>

                <form method="POST" action="{{ route('doctor.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="form-label" for="doctor_name">Full Name</label>
                            <input id="doctor_name" type="text" name="name" class="form-input" value="{{ old('name', $doctor?->name ?? '') }}" required>
                            @error('name')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_employee_id">Employee ID</label>
                            <input id="doctor_employee_id" type="text" name="employee_id" class="form-input" value="{{ old('employee_id', $doctor?->employee_id ?? '') }}" placeholder="EMP-1024">
                            @error('employee_id')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_phone">Phone Number</label>
                            <input id="doctor_phone" type="text" name="phone" class="form-input" value="{{ old('phone', $doctor?->phone ?? $doctor?->user?->phone ?? '') }}" required>
                            @error('phone')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_email">Email</label>
                            <input id="doctor_email" type="email" name="email" class="form-input" value="{{ old('email', $doctor?->email ?? $doctor?->user?->email ?? '') }}" required>
                            @error('email')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_gender">Gender</label>
                            <select id="doctor_gender" name="gender" class="form-input">
                                <option value="">Select gender</option>
                                <option value="male" {{ old('gender', $doctor?->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $doctor?->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $doctor?->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_dob">Date of Birth</label>
                            <input id="doctor_dob" type="date" name="dob" class="form-input" value="{{ old('dob', $doctor?->dob?->format('Y-m-d') ?? '') }}">
                            @error('dob')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_blood_group">Blood Group</label>
                            <select id="doctor_blood_group" name="blood_group" class="form-input">
                                <option value="">Select blood group</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                    <option value="{{ $group }}" {{ old('blood_group', $doctor?->blood_group ?? '') === $group ? 'selected' : '' }}>{{ $group }}</option>
                                @endforeach
                            </select>
                            @error('blood_group')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="doctor_joining_date">Joining Date</label>
                            <input id="doctor_joining_date" type="date" name="joining_date" class="form-input" value="{{ old('joining_date', $doctor?->joining_date?->format('Y-m-d') ?? '') }}">
                            @error('joining_date')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label" for="doctor_address">Address</label>
                            <textarea id="doctor_address" name="address" rows="4" class="form-input">{{ old('address', $doctor?->address ?? '') }}</textarea>
                            @error('address')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-slate-50/80 p-5">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Professional details</p>
                                <h4 class="mt-1 text-lg font-bold text-slate-900">Clinic profile</h4>
                            </div>
                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">Visible to patients</span>
                        </div>

                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="form-label" for="doctor_specialization">Specialization</label>
                                <input id="doctor_specialization" type="text" name="specialization" class="form-input" value="{{ old('specialization', $doctor?->specialization ?? '') }}" placeholder="Cardiology, Dermatology...">
                                @error('specialization')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="doctor_experience_years">Experience (years)</label>
                                <input id="doctor_experience_years" type="number" min="0" max="80" name="experience_years" class="form-input" value="{{ old('experience_years', $doctor?->experience_years ?? '') }}" placeholder="10">
                                @error('experience_years')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="doctor_consultation_fee">Consultation fee (₹)</label>
                                <input id="doctor_consultation_fee" type="number" min="0" step="0.01" name="consultation_fee" class="form-input" value="{{ old('consultation_fee', $doctor?->consultation_fee ?? '') }}" placeholder="500">
                                @error('consultation_fee')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="form-label" for="doctor_image">Profile image</label>
                                <input id="doctor_image" type="file" name="image" accept="image/*" class="form-input">
                                @error('image')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="form-label" for="doctor_bio">About / Bio</label>
                                <textarea id="doctor_bio" name="bio" rows="4" class="form-input" placeholder="Short professional bio...">{{ old('bio', $doctor?->bio ?? '') }}</textarea>
                                @error('bio')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-5">
                        <a href="{{ route('doctor.dashboard') }}" class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
                        <button type="submit" class="rounded-2xl bg-slate-900 px-5 py-2 text-sm font-semibold text-white hover:bg-slate-800">Save Changes</button>
                    </div>
                </form>
            </div>

            <aside class="space-y-6">
                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Security</p>
                    <h4 class="mt-2 text-lg font-bold text-slate-900">Password</h4>
                    <p class="mt-2 text-sm text-slate-600">Keep your account secure by updating your password periodically.</p>
                    <form method="POST" action="{{ route('doctor.change-password.update') }}" class="mt-4 space-y-3">
                        @csrf
                        <div>
                            <label class="form-label" for="current_password">Current password</label>
                            <input id="current_password" name="current_password" type="password" class="form-input" required>
                            @error('current_password')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="new_password">New password</label>
                            <input id="new_password" name="new_password" type="password" class="form-input" required>
                            @error('new_password')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label" for="confirm_password">Confirm new password</label>
                            <input id="confirm_password" name="confirm_password" type="password" class="form-input" required>
                            @error('confirm_password')<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="w-full rounded-2xl bg-sky-600 px-5 py-2 text-sm font-semibold text-white hover:bg-sky-700">Change Password</button>
                    </form>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Quick Summary</p>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-slate-500">Department</span>
                            <span class="font-semibold text-slate-900">{{ $doctorDepartment }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-slate-500">Qualification</span>
                            <span class="font-semibold text-slate-900">{{ $doctorQualification }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-slate-500">Experience</span>
                            <span class="font-semibold text-slate-900">{{ $experienceYears }} years</span>
                        </div>
                    </div>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">Availability</p>
                    <div class="mt-4 space-y-3">
                        @forelse($availabilitySummary as $day)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <div class="flex items-center justify-between gap-3">
                                    <span class="font-semibold text-slate-900">{{ $day['day'] }}</span>
                                    <span class="text-xs font-semibold text-sky-700">{{ count($day['slots']) }} slots</span>
                                </div>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($day['slots'] as $slot)
                                        <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600 shadow-sm">{{ $slot }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-sm text-slate-500">No availability slots have been set yet.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </section>
    </div>
@endsection