@extends('admin.layouts.app')

@section('title', 'Add Doctor')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-4">
                <a href="{{ route('admin.doctors.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-white">
                    <span aria-hidden="true">←</span> Back to Doctors
                </a>
            </div>
            <h2 class="text-2xl font-bold mb-4">Create Doctor Account</h2>

            @if(session('success'))
                <div class="mb-4 rounded-lg bg-emerald-50 p-3 text-emerald-800">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.doctors.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label">Full name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
                    @error('name')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
                    @error('email')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-input" required>
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" required>
                        @error('password')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Confirm password</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>
                </div>

                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" inputmode="numeric" pattern="[0-9]{10,15}" minlength="10" maxlength="15" required>
                    @error('phone')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label">Specialization</label>
                    <input type="text" name="specialization" value="{{ old('specialization') }}" class="form-input">
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn btn-primary">Create doctor</button>
                    <a href="{{ route('admin.doctors.index') }}" class="ml-3 text-sm text-slate-600">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
