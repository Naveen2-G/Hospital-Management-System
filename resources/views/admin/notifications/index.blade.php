@extends('admin.layouts.app')
@section('title', 'Notifications')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Notifications</h1><p class="text-sm text-gray-500 mt-1">All system notifications</p></div>
        <a href="{{ route('admin.notifications.index', ['mark_read'=>1]) }}" class="btn btn-secondary btn-sm">Mark All Read</a>
    </div>
    <div class="admin-card mb-6">
        <form method="GET" class="flex gap-3">
            <select name="type" class="form-input w-auto" onchange="this.form.submit()"><option value="">All Types</option>@foreach(['appointment','billing','system','alert'] as $t)<option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ ucfirst($t) }}</option>@endforeach</select>
            @if(request('type'))<a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary btn-sm">Clear</a>@endif
        </form>
    </div>
    <div class="space-y-3">
        @forelse($notifications as $n)
        <div class="admin-card flex items-start gap-4 {{ !$n->is_read ? 'border-l-4 border-l-primary-500' : '' }}">
            @php
                $icons = ['appointment'=>'bg-blue-50 text-blue-600','billing'=>'bg-emerald-50 text-emerald-600','alert'=>'bg-red-50 text-red-600'];
                $ic = $icons[$n->type] ?? 'bg-gray-50 text-gray-600';
            @endphp
            <div class="w-10 h-10 rounded-full {{ $ic }} flex items-center justify-center shrink-0">
                @if($n->type==='appointment')<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                @elseif($n->type==='billing')<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @else<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 {{ !$n->is_read ? 'font-semibold' : '' }}">{{ $n->title }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $n->message }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $n->created_at->diffForHumans() }}</p>
            </div>
            @if(!$n->is_read)<div class="w-2 h-2 bg-primary-500 rounded-full shrink-0 mt-2"></div>@endif
        </div>
        @empty<div class="admin-card empty-state py-12"><p class="text-sm">No notifications.</p></div>@endforelse
    </div>
    <div class="mt-6">{{ $notifications->links() }}</div>
@endsection
