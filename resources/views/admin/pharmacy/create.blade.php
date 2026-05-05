@extends('admin.layouts.app')
@section('title', isset($medicine) ? 'Edit Medicine' : 'Add Medicine')
@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.pharmacy.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ isset($medicine) ? 'Edit Medicine' : 'Add Medicine' }}</h1>
    </div>
    <div class="admin-card max-w-2xl">
        <form method="POST" action="{{ isset($medicine) ? route('admin.pharmacy.update', $medicine) : route('admin.pharmacy.store') }}">
            @csrf @if(isset($medicine)) @method('PUT') @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Name *</label><input type="text" name="name" value="{{ old('name', $medicine->name ?? '') }}" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Category</label><input type="text" name="category" value="{{ old('category', $medicine->category ?? '') }}" class="form-input" placeholder="e.g. Analgesic, Antibiotic"></div>
                <div class="form-group"><label class="form-label">Manufacturer</label><input type="text" name="manufacturer" value="{{ old('manufacturer', $medicine->manufacturer ?? '') }}" class="form-input"></div>
                <div class="form-group"><label class="form-label">Unit Price (₹) *</label><input type="number" name="unit_price" value="{{ old('unit_price', $medicine->unit_price ?? 0) }}" class="form-input" min="0" step="0.01" required></div>
                <div class="form-group"><label class="form-label">Stock Quantity *</label><input type="number" name="stock_quantity" value="{{ old('stock_quantity', $medicine->stock_quantity ?? 0) }}" class="form-input" min="0" required></div>
                <div class="form-group"><label class="form-label">Reorder Level</label><input type="number" name="reorder_level" value="{{ old('reorder_level', $medicine->reorder_level ?? 10) }}" class="form-input" min="0"></div>
                <div class="form-group"><label class="form-label">Expiry Date</label><input type="date" name="expiry_date" value="{{ old('expiry_date', isset($medicine) && $medicine->expiry_date ? $medicine->expiry_date->format('Y-m-d') : '') }}" class="form-input"></div>
                <div class="form-group"><label class="form-label">Status</label><select name="status" class="form-input">@foreach(['available','out_of_stock','expired'] as $s)<option value="{{ $s }}" {{ old('status', $medicine->status ?? 'available')===$s?'selected':'' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100">
                <button type="submit" class="btn btn-primary">{{ isset($medicine) ? 'Update' : 'Add Medicine' }}</button>
                <a href="{{ route('admin.pharmacy.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
