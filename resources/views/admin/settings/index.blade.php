@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Settings</h1><p class="text-sm text-gray-500 mt-1">Manage hospital and system settings</p></div>
    <form method="POST" action="{{ route('admin.settings.update') }}">@csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Hospital Information</h2>
                <div class="space-y-4">
                    @php $get = fn($k) => $settings->flatten()->firstWhere('key', $k)?->value ?? ''; @endphp
                    <div class="form-group"><label class="form-label">Hospital Name</label><input type="text" name="hospital_name" value="{{ $get('hospital_name') }}" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Address</label><textarea name="hospital_address" rows="2" class="form-input">{{ $get('hospital_address') }}</textarea></div>
                    <div class="form-group"><label class="form-label">Phone</label><input type="text" name="hospital_phone" value="{{ $get('hospital_phone') }}" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Email</label><input type="email" name="hospital_email" value="{{ $get('hospital_email') }}" class="form-input"></div>
                </div>
            </div>
            <div class="admin-card">
                <h2 class="text-base font-semibold text-gray-900 mb-4">Department Management</h2>
                <div class="space-y-3">
                    @foreach($departments as $dept)
                    <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                        <span class="text-sm text-gray-800">{{ $dept->name }}</span>
                        <select name="dept_status[{{ $dept->id }}]" class="form-input w-auto text-sm py-1">
                            <option value="active" {{ $dept->status==='active'?'selected':'' }}>Active</option>
                            <option value="inactive" {{ $dept->status==='inactive'?'selected':'' }}>Inactive</option>
                        </select>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
@endsection
