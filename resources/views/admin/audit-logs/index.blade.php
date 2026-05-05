@extends('admin.layouts.app')
@section('title', 'Audit Logs')
@section('content')
    <div class="mb-6"><h1 class="text-2xl font-bold text-gray-900">Audit Logs</h1><p class="text-sm text-gray-500 mt-1">Track all system activity</p></div>
    <div class="admin-card mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="action" class="form-input w-auto" onchange="this.form.submit()"><option value="">All Actions</option>@foreach(['login','logout','create','update','delete'] as $a)<option value="{{ $a }}" {{ request('action')===$a?'selected':'' }}>{{ ucfirst($a) }}</option>@endforeach</select>
            <input type="date" name="date" value="{{ request('date') }}" class="form-input w-auto" onchange="this.form.submit()">
            @if(request()->hasAny(['action','date']))<a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary btn-sm">Clear</a>@endif
        </form>
    </div>
    <div class="admin-card p-0 overflow-hidden">
        @if($logs->isEmpty())<div class="empty-state py-16"><p class="text-sm">No audit logs found.</p></div>
        @else
            <table class="admin-table"><thead><tr><th class="pl-6">User</th><th>Action</th><th>Model</th><th>Description</th><th>IP Address</th><th>Date</th></tr></thead>
            <tbody>@foreach($logs as $log)<tr>
                <td class="pl-6"><div class="flex items-center gap-2"><div class="w-6 h-6 bg-gray-100 text-gray-500 rounded-full flex items-center justify-center text-xs font-bold">{{ $log->user ? strtoupper(substr($log->user->name,0,1)) : '?' }}</div><span class="text-sm">{{ $log->user->name ?? 'System' }}</span></div></td>
                <td>@php $ac=['login'=>'badge-success','logout'=>'badge-gray','create'=>'badge-info','update'=>'badge-warning','delete'=>'badge-danger']; @endphp<span class="badge {{ $ac[$log->action]??'badge-gray' }}">{{ ucfirst($log->action) }}</span></td>
                <td class="text-gray-500">{{ $log->model_type ? class_basename($log->model_type) : '—' }}</td>
                <td class="text-sm text-gray-700 max-w-xs truncate">{{ $log->description ?? '—' }}</td>
                <td class="text-gray-400 text-xs font-mono">{{ $log->ip_address ?? '—' }}</td>
                <td class="text-gray-500 text-sm">{{ $log->created_at->format('M d, Y H:i') }}</td>
            </tr>@endforeach</tbody></table>
            <div class="px-6 py-4 border-t border-gray-100">{{ $logs->links() }}</div>
        @endif
    </div>
@endsection
