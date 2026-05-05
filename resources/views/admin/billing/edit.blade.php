@extends('admin.layouts.app')
@section('title', 'Edit Invoice')
@section('content')
    <div class="mb-6"><a href="{{ route('admin.billing.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a><h1 class="text-2xl font-bold text-gray-900 mt-2">Edit Invoice {{ $invoice->invoice_number }}</h1></div>
    <div class="admin-card max-w-2xl">
        <form method="POST" action="{{ route('admin.billing.update', $invoice) }}">@csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Due Date</label><input type="date" name="due_date" value="{{ $invoice->due_date?->format('Y-m-d') }}" class="form-input"></div>
                <div class="form-group"><label class="form-label">Record Payment (₹)</label><input type="number" name="payment_amount" class="form-input" min="0" step="0.01" placeholder="0.00"></div>
                <div class="form-group"><label class="form-label">Payment Method</label><select name="payment_method" class="form-input">@foreach(['cash','card','online','insurance'] as $m)<option value="{{ $m }}">{{ ucfirst($m) }}</option>@endforeach</select></div>
            </div>
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100"><button type="submit" class="btn btn-primary">Update Invoice</button><a href="{{ route('admin.billing.show', $invoice) }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
@endsection
