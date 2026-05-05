@extends('admin.layouts.app')
@section('title', 'Rooms')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Room & Bed Management</h1><p class="text-sm text-gray-500 mt-1">Manage hospital rooms and bed allocation</p></div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>Add Room</a>
    </div>
    <div class="admin-card mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="type" class="form-input w-auto" onchange="this.form.submit()"><option value="">All Types</option>@foreach(['ICU','General','Private','Semi-Private'] as $t)<option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ $t }}</option>@endforeach</select>
            <select name="status" class="form-input w-auto" onchange="this.form.submit()"><option value="">All Status</option>@foreach(['available','occupied','maintenance'] as $s)<option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach</select>
            @if(request()->hasAny(['type','status']))<a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm">Clear</a>@endif
        </form>
    </div>
    <div class="admin-card p-0 overflow-hidden">
        @if($rooms->isEmpty())
            <div class="empty-state py-16"><p class="text-sm">No rooms found.</p></div>
        @else
            <table class="admin-table">
                <thead><tr><th class="pl-6">Room #</th><th>Type</th><th>Floor</th><th>Capacity</th><th>Beds Available</th><th>Rate/Day</th><th>Status</th><th class="pr-6 text-right">Actions</th></tr></thead>
                <tbody>
                    @foreach($rooms as $room)
                    <tr>
                        <td class="pl-6 font-medium text-gray-900">{{ $room->room_number }}</td>
                        <td><span class="badge {{ $room->type==='ICU'?'badge-danger':($room->type==='Private'?'badge-info':'badge-gray') }}">{{ $room->type }}</span></td>
                        <td>{{ $room->floor ?? '—' }}</td>
                        <td>{{ $room->capacity }}</td>
                        <td><span class="font-medium {{ $room->available_beds_count > 0 ? 'text-emerald-600' : 'text-red-600' }}">{{ $room->available_beds_count }}</span> / {{ $room->beds_count }}</td>
                        <td>₹{{ number_format($room->rate_per_day) }}</td>
                        <td><span class="badge {{ $room->status==='available'?'badge-success':($room->status==='occupied'?'badge-warning':'badge-gray') }}">{{ ucfirst($room->status) }}</span></td>
                        <td class="pr-6 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.rooms.show', $room) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></a>
                                <a href="{{ route('admin.rooms.edit', $room) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg></a>
                                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this item? This action cannot be undone.');">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 cursor-pointer"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg></button></form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">{{ $rooms->links() }}</div>
        @endif
    </div>
@endsection
