@extends('admin.layouts.app')
@section('title', 'Appointments')
@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Appointments</h1>
            <p class="text-sm text-gray-500 mt-1">Manage all patient appointments</p>
        </div>
        <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            New Appointment
        </a>
    </div>

    {{-- Filters --}}
    <div class="admin-card mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <select name="status" class="form-input w-auto" onchange="this.form.submit()">
                <option value="">All Status</option>
                @foreach(['pending','confirmed','completed','cancelled'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <input type="date" name="date" value="{{ request('date') }}" class="form-input w-auto" onchange="this.form.submit()">
            @if(request()->hasAny(['status','date']))
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        @if($appointments->isEmpty())
            <div class="empty-state py-16"><p class="text-sm">No appointments found.</p></div>
        @else
            <table class="admin-table">
                <thead>
                    <tr>
                        <th class="pl-6">Patient</th>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $apt)
                    <tr>
                        <td class="pl-6 font-medium text-gray-900">
                            {{ $apt->patient_name }}
                            @if(!$apt->patient_id)
                                <span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-[0.65rem] font-medium bg-amber-100 text-amber-800">Guest</span>
                            @endif
                        </td>
                        <td>{{ $apt->doctor->name ?? '—' }}</td>
                        <td>{{ $apt->department->name ?? '—' }}</td>
                        <td>{{ $apt->appointment_date->format('M d, Y') }}</td>
                        <td>{{ $apt->time_slot }}</td>
                        <td><span class="badge {{ $apt->type==='emergency' ? 'badge-danger' : ($apt->type==='video' ? 'badge-info' : 'badge-gray') }}">{{ ucfirst($apt->type) }}</span></td>
                        <td>
                            @php $bm=['pending'=>'badge-warning','confirmed'=>'badge-info','completed'=>'badge-success','cancelled'=>'badge-danger']; @endphp
                            <span class="badge {{ $bm[$apt->status] ?? 'badge-gray' }}">{{ ucfirst($apt->status) }}</span>
                        </td>
                        <td class="pr-6 text-right">
                            <a href="{{ route('admin.appointments.edit', $apt) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-100">{{ $appointments->links() }}</div>
        @endif
    </div>
@endsection
