@extends('patient.layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="patient-card p-6 sm:p-8">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-emerald-600">Account security</p>
                    <h2 class="mt-1 text-2xl font-extrabold text-slate-900">Change your password</h2>
                    <p class="mt-2 text-sm text-slate-500">Use a strong password with uppercase, lowercase, and numbers.</p>
                </div>
                <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Back to dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('patient.change-password.update') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="current_password" class="mb-1.5 block text-sm font-semibold text-slate-700">Current password</label>
                    <input type="password" name="current_password" id="current_password" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                    @error('current_password')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_password" class="mb-1.5 block text-sm font-semibold text-slate-700">New password</label>
                    <input type="password" name="new_password" id="new_password" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                    @error('new_password')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="confirm_password" class="mb-1.5 block text-sm font-semibold text-slate-700">Confirm new password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm focus:border-emerald-400 focus:outline-none focus:ring-4 focus:ring-emerald-100" required>
                    @error('confirm_password')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    Your password must be at least 8 characters and include uppercase letters, lowercase letters, and numbers.
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                        Update password
                    </button>
                    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection