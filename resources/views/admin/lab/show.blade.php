@extends('admin.layouts.app')
@section('title', $labTest->name)
@section('content')
    <div class="mb-6"><a href="{{ route('admin.lab-tests.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <div class="flex items-center justify-between mt-2"><h1 class="text-2xl font-bold text-gray-900">{{ $labTest->name }}</h1><a href="{{ route('admin.lab-tests.edit', $labTest) }}" class="btn btn-secondary btn-sm">Edit</a></div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card"><dl class="space-y-4"><div><dt class="text-xs font-medium text-gray-400 uppercase">Category</dt><dd class="text-sm text-gray-800 mt-1">{{ $labTest->category ?? '—' }}</dd></div><div><dt class="text-xs font-medium text-gray-400 uppercase">Price</dt><dd class="text-sm text-gray-800 mt-1">₹{{ number_format($labTest->price) }}</dd></div>@if($labTest->description)<div><dt class="text-xs font-medium text-gray-400 uppercase">Description</dt><dd class="text-sm text-gray-800 mt-1">{{ $labTest->description }}</dd></div>@endif</dl></div>
        <div class="admin-card p-0 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100"><h2 class="text-base font-semibold text-gray-900">Orders for this test</h2></div>
            @if($orders->isEmpty())<div class="empty-state py-12"><p class="text-sm">No orders yet.</p></div>
            @else
                <div class="space-y-4 p-4">
                    @foreach($orders as $o)
                        @php $bm=['requested'=>'badge-warning','in_progress'=>'badge-info','completed'=>'badge-success']; @endphp
                        <form method="POST" action="{{ route('admin.lab-orders.update', $o) }}" enctype="multipart/form-data" class="rounded-2xl border border-gray-200 bg-white p-4">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <p class="text-xs uppercase text-gray-400">Patient</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $o->patient->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-gray-400">Doctor</p>
                                    <p class="text-sm font-semibold text-gray-900">Dr. {{ $o->doctor->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase text-gray-400">Ordered</p>
                                    <p class="text-sm text-gray-700">{{ $o->ordered_at?->format('M d, Y h:i A') ?? $o->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-input" required>
                                        <option value="requested" {{ $o->status === 'requested' ? 'selected' : '' }}>Requested</option>
                                        <option value="in_progress" {{ $o->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ $o->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    <span class="mt-2 inline-flex badge {{ $bm[$o->status]??'badge-gray' }}">Current: {{ ucwords(str_replace('_',' ',$o->status)) }}</span>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Result / Details</label>
                                    <textarea name="result" rows="3" class="form-input" placeholder="Add findings, values, and notes">{{ old('result', $o->result) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="form-label">Upload Report (PDF/Image)</label>
                                    <input type="file" name="report_file" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
                                    @if($o->report_file)
                                        <a href="{{ route('lab-orders.report', $o) }}" target="_blank" class="mt-2 inline-block text-xs font-semibold text-sky-700 hover:text-sky-800">View current report</a>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="btn btn-primary btn-sm">Update Lab Order</button>
                            </div>
                        </form>
                    @endforeach
                </div>
                <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
            @endif
        </div>
    </div>
@endsection
