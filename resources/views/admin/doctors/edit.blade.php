@extends('admin.layouts.app')

@section('title', 'Edit Doctor')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.doctors.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Doctors
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Edit Doctor</h1>
    </div>

    <div class="admin-card max-w-3xl">
        <form method="POST" action="{{ route('admin.doctors.update', $doctor) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $doctor->name ?? '') }}" class="form-input" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $doctor->email ?? '') }}" class="form-input">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $doctor->phone ?: '1111111111') }}" class="form-input" inputmode="numeric" pattern="[0-9]{10,15}" minlength="10" maxlength="15" required>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Department <span class="text-red-500">*</span></label>
                    <select name="department_id" class="form-input" required>
                        <option value="">Select</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}" {{ old('department_id', $doctor->department_id ?? '') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" class="form-input">
                    @error('specialization') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" value="{{ old('qualification', $doctor->qualification ?? '') }}" class="form-input">
                    @error('qualification') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Experience (years)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $doctor->experience_years ?? 0) }}" class="form-input" min="0">
                    @error('experience_years') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Consultation Fee (₹)</label>
                    <input type="number" name="consultation_fee" value="{{ old('consultation_fee', $doctor->consultation_fee ?? 0) }}" class="form-input" min="0" step="0.01">
                    @error('consultation_fee') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="active" {{ old('status', $doctor->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $doctor->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="form-group md:col-span-2">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" rows="3" class="form-input">{{ old('bio', $doctor->bio ?? '') }}</textarea>
                    @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary">Update Doctor</button>
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
