@extends('admin.layouts.app')
@section('title', $medicine->name)
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pharmacy.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <div class="flex items-center justify-between mt-2"><h1 class="text-2xl font-bold text-gray-900">{{ $medicine->name }}</h1><a href="{{ route('admin.pharmacy.edit', $medicine) }}" class="btn btn-secondary btn-sm">Edit</a></div>
    </div>
    <div class="admin-card max-w-3xl">
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Category</dt><dd class="text-sm text-gray-800 mt-1">{{ $medicine->category ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Manufacturer</dt><dd class="text-sm text-gray-800 mt-1">{{ $medicine->manufacturer ?? '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Unit Price</dt><dd class="text-sm text-gray-800 mt-1">₹{{ number_format($medicine->unit_price, 2) }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Stock</dt><dd class="text-sm mt-1"><span class="font-semibold {{ $medicine->stock_quantity <= $medicine->reorder_level ? 'text-red-600' : 'text-emerald-600' }}">{{ $medicine->stock_quantity }}</span> units</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Reorder Level</dt><dd class="text-sm text-gray-800 mt-1">{{ $medicine->reorder_level }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Expiry Date</dt><dd class="text-sm text-gray-800 mt-1">{{ $medicine->expiry_date ? $medicine->expiry_date->format('M d, Y') : '—' }}</dd></div>
            <div><dt class="text-xs font-medium text-gray-400 uppercase">Status</dt><dd class="mt-1"><span class="badge {{ $medicine->status==='available'?'badge-success':($medicine->status==='expired'?'badge-danger':'badge-warning') }}">{{ ucwords(str_replace('_',' ',$medicine->status)) }}</span></dd></div>
        </dl>
    </div>
@endsection
