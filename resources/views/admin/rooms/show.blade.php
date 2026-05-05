@extends('admin.layouts.app')
@section('title', 'Room ' . $room->room_number)
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <div class="flex items-center justify-between mt-2">
            <h1 class="text-2xl font-bold text-gray-900">Room {{ $room->room_number }}</h1>
            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-secondary btn-sm">Edit</a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card lg:col-span-2">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Room Details</h2>
            <dl class="grid grid-cols-2 gap-4 mb-6">
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Type</dt><dd class="text-sm text-gray-800 mt-1">{{ $room->type }}</dd></div>
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Floor</dt><dd class="text-sm text-gray-800 mt-1">{{ $room->floor ?? '—' }}</dd></div>
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Capacity</dt><dd class="text-sm text-gray-800 mt-1">{{ $room->capacity }} beds</dd></div>
                <div><dt class="text-xs font-medium text-gray-400 uppercase">Rate/Day</dt><dd class="text-sm text-gray-800 mt-1">₹{{ number_format($room->rate_per_day) }}</dd></div>
            </dl>
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Beds</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach($room->beds as $bed)
                <div class="p-3 rounded-lg border {{ $bed->status==='available' ? 'border-emerald-200 bg-emerald-50' : 'border-red-200 bg-red-50' }}">
                    <p class="text-sm font-medium {{ $bed->status==='available' ? 'text-emerald-700' : 'text-red-700' }}">{{ $bed->bed_number }}</p>
                    <p class="text-xs {{ $bed->status==='available' ? 'text-emerald-500' : 'text-red-500' }}">{{ ucfirst($bed->status) }}</p>
                </div>
                @endforeach
            </div>
        </div>
        <div class="admin-card text-center">
            <div class="w-16 h-16 bg-violet-50 text-violet-600 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-3">{{ $room->room_number }}</div>
            <span class="badge {{ $room->status==='available'?'badge-success':($room->status==='occupied'?'badge-warning':'badge-gray') }}">{{ ucfirst($room->status) }}</span>
        </div>
    </div>
@endsection
