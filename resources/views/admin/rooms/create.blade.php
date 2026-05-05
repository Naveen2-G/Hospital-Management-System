@extends('admin.layouts.app')
@section('title', isset($room) ? 'Edit Room' : 'Add Room')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back to Rooms</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($room) ? 'Edit Room' : 'Add New Room' }}</h1>
    </div>
    <div class="admin-card max-w-2xl">
        <form method="POST" action="{{ isset($room) ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}">
            @csrf @if(isset($room)) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Room Number *</label><input type="text" name="room_number" value="{{ old('room_number', $room->room_number ?? '') }}" class="form-input" required>@error('room_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div class="form-group"><label class="form-label">Type *</label><select name="type" class="form-input" required>@foreach(['ICU','General','Private','Semi-Private'] as $t)<option value="{{ $t }}" {{ old('type', $room->type ?? '')===$t?'selected':'' }}>{{ $t }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label">Floor</label><input type="text" name="floor" value="{{ old('floor', $room->floor ?? '') }}" class="form-input"></div>
                <div class="form-group"><label class="form-label">Capacity *</label><input type="number" name="capacity" value="{{ old('capacity', $room->capacity ?? 1) }}" class="form-input" min="1" required></div>
                <div class="form-group"><label class="form-label">Rate per Day (₹) *</label><input type="number" name="rate_per_day" value="{{ old('rate_per_day', $room->rate_per_day ?? 0) }}" class="form-input" min="0" step="0.01" required></div>
                @if(isset($room))<div class="form-group"><label class="form-label">Status</label><select name="status" class="form-input">@foreach(['available','occupied','maintenance'] as $s)<option value="{{ $s }}" {{ $room->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select></div>@endif
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary">{{ isset($room) ? 'Update Room' : 'Add Room' }}</button>
                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
