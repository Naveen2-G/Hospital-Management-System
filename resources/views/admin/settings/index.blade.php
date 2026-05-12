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
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-semibold text-gray-900">Department Management</h2>
                    <span class="badge badge-info">{{ $departments->count() }} Total</span>
                </div>
                <div class="space-y-1">
                    <div class="grid grid-cols-2 px-2 py-2 border-b border-gray-100 bg-gray-50/50 rounded-t-lg">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Department Name</span>
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Status</span>
                    </div>
                    @foreach($departments as $dept)
                    <div class="grid grid-cols-2 items-center px-2 py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50/50 transition-colors">
                        <span class="text-sm font-medium text-gray-800">{{ $dept->name }}</span>
                        <div class="flex justify-end">
                            <select name="dept_status[{{ $dept->id }}]" class="form-input text-sm py-2 w-32 cursor-pointer focus:ring-2 focus:ring-blue-500/20">
                                <option value="active" {{ $dept->status==='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ $dept->status==='inactive'?'selected':'' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="text-[11px] text-gray-400 mt-4 italic">* Inactive departments will be hidden from public booking forms.</p>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
@endsection
