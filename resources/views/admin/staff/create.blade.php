@extends('admin.layouts.app')
@section('title', isset($staff) ? 'Edit Staff' : 'Add Staff')
@section('content')
    <div class="mb-6"><a href="{{ route('admin.staff.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a><h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($staff) && $staff->exists ? 'Edit Staff' : 'Add Staff Member' }}</h1></div>
    <div class="admin-card max-w-3xl">
        <form method="POST" action="{{ isset($staff) && $staff->exists ? route('admin.staff.update', $staff) : route('admin.staff.store') }}">@csrf @if(isset($staff) && $staff->exists) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Full Name *</label><input type="text" name="name" value="{{ old('name', $staff->name ?? '') }}" class="form-input" required>@error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email', $staff->email ?? '') }}" class="form-input">@error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Phone <span class="text-red-500">*</span></label><input type="text" name="phone" value="{{ old('phone', $staff->phone ?? '') }}" class="form-input" required>@error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Designation</label><input type="text" name="designation" value="{{ old('designation', $staff->designation ?? '') }}" class="form-input" placeholder="e.g. Head Nurse">@error('designation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Department</label><select name="department_id" class="form-input"><option value="">Select</option>@foreach($departments as $d)<option value="{{ $d->id }}" {{ old('department_id', $staff->department_id ?? '')==$d->id?'selected':'' }}>{{ $d->name }}</option>@endforeach</select>@error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Joining Date</label><input type="date" name="joining_date" value="{{ old('joining_date', isset($staff) && $staff->joining_date ? $staff->joining_date->format('Y-m-d') : '') }}" class="form-input">@error('joining_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Salary (₹)</label><input type="number" name="salary" value="{{ old('salary', $staff->salary ?? 0) }}" class="form-input" min="0" step="0.01">@error('salary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
                <div class="form-group"><label class="form-label">Status</label><select name="status" class="form-input"><option value="active" {{ old('status', $staff->status ?? 'active')==='active'?'selected':'' }}>Active</option><option value="inactive" {{ old('status', $staff->status ?? '')==='inactive'?'selected':'' }}>Inactive</option></select>@error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror</div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100"><button type="submit" class="btn btn-primary">{{ isset($staff) && $staff->exists ? 'Update' : 'Add Staff' }}</button><a href="{{ route('admin.staff.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
@endsection
