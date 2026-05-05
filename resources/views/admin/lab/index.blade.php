@extends('admin.layouts.app')
@section('title', 'Laboratory')
@section('content')
    @if(session('success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div><h1 class="text-2xl font-bold text-gray-900">Laboratory Management</h1><p class="text-sm text-gray-500 mt-1">Manage lab tests and orders</p></div>
        <a href="{{ route('admin.lab-tests.create') }}" class="btn btn-primary"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>Add Test</a>
    </div>
    <div class="admin-card mb-6">
        <form method="GET" class="flex gap-3"><div class="relative flex-1"><svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg><input type="text" name="search" value="{{ request('search') }}" placeholder="Search tests..." class="form-input pl-10"></div><button type="submit" class="btn btn-secondary">Search</button></form>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card p-0 overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 border-b border-gray-100"><h2 class="text-base font-semibold text-gray-900">Lab Tests</h2></div>
            @if($labTests->isEmpty())<div class="empty-state py-12"><p class="text-sm">No lab tests found.</p></div>
            @else
                <table class="admin-table">
                    <thead><tr><th class="pl-6">Test Name</th><th>Category</th><th>Price</th><th>Orders</th><th class="pr-6 text-right">Actions</th></tr></thead>
                    <tbody>
                        @foreach($labTests as $test)
                        <tr>
                            <td class="pl-6 font-medium text-gray-900">{{ $test->name }}</td>
                            <td>{{ $test->category ?? '—' }}</td>
                            <td>₹{{ number_format($test->price) }}</td>
                            <td><span class="badge badge-gray">{{ $test->orders_count }}</span></td>
                            <td class="pr-6 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.lab-tests.show', $test) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></a>
                                    <a href="{{ route('admin.lab-tests.edit', $test) }}" class="p-1.5 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-primary-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg></a>
                                    <form method="POST" action="{{ route('admin.lab-tests.destroy', $test) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this item? This action cannot be undone.');">@csrf @method('DELETE')<button type="submit" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 cursor-pointer"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg></button></form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-100">{{ $labTests->links() }}</div>
            @endif
        </div>
        <div class="admin-card">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Recent Lab Orders</h2>
            @forelse($recentOrders as $order)
                @php $bm=['requested'=>'badge-warning','in_progress'=>'badge-info','completed'=>'badge-success']; @endphp
                @if($order->status === 'completed')
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/50 p-3 {{ !$loop->last ? 'mb-3' : '' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-emerald-900">{{ $order->labTest->name ?? '—' }}</p>
                                <p class="text-xs text-emerald-700">{{ $order->patient->name ?? '—' }} · Dr. {{ $order->doctor->name ?? '—' }}</p>
                            </div>
                            <span class="badge badge-success">Completed</span>
                        </div>
                        <p class="mt-2 text-xs text-emerald-800">{{ $order->result ?: 'No lab notes added.' }}</p>
                        @if($order->report_file)
                            <a href="{{ route('lab-orders.report', $order) }}" target="_blank" class="mt-2 inline-block text-xs font-semibold text-emerald-800 hover:text-emerald-900">View uploaded report</a>
                        @endif
                    </div>
                @else
                    <form method="POST" action="{{ route('admin.lab-orders.update', $order) }}" enctype="multipart/form-data" class="rounded-xl border border-gray-200 bg-white p-3 {{ !$loop->last ? 'mb-3' : '' }}">
                        @csrf
                        @method('PUT')

                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $order->labTest->name ?? '—' }}</p>
                                <p class="text-xs text-gray-500">{{ $order->patient->name ?? '—' }} · Dr. {{ $order->doctor->name ?? '—' }}</p>
                            </div>
                            <span class="badge {{ $bm[$order->status]??'badge-gray' }}">{{ ucwords(str_replace('_',' ',$order->status)) }}</span>
                        </div>

                        <div class="mt-3 space-y-3">
                            <div>
                                <label class="form-label">Status</label>
                                <select name="status" class="form-input" required>
                                    <option value="requested" {{ $order->status === 'requested' ? 'selected' : '' }}>Requested</option>
                                    <option value="in_progress" {{ $order->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Lab Notes / Result</label>
                                <textarea name="result" rows="2" class="form-input" placeholder="Enter notes and findings">{{ old('result', $order->result) }}</textarea>
                            </div>

                            <div>
                                <label class="form-label">Upload Report File</label>
                                <input type="file" name="report_file" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
                                @if($order->report_file)
                                    <a href="{{ route('lab-orders.report', $order) }}" target="_blank" class="mt-1 inline-block text-xs font-semibold text-sky-700 hover:text-sky-800">View current report</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm w-full">Update Lab Order</button>
                        </div>
                    </form>
                @endif
            @empty
                <p class="text-sm text-gray-400">No recent orders.</p>
            @endforelse
        </div>
    </div>
@endsection
