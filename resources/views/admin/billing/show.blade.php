@extends('admin.layouts.app')
@section('title', 'Invoice ' . $invoice->invoice_number)
@section('content')
    <div class="mb-6"><a href="{{ route('admin.billing.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a>
        <div class="flex items-center justify-between mt-2">
            <h1 class="text-2xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h1>
            <a href="{{ route('admin.billing.print', $invoice) }}" target="_blank" class="btn btn-primary btn-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.75 12h.008v.008h-.008V12zm-2.25 0h.008v.008H16.5V12z"/></svg>
                Print Invoice
            </a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="admin-card lg:col-span-2">
            <div class="flex justify-between mb-6"><div><h2 class="text-lg font-semibold text-gray-900">Invoice Details</h2><p class="text-sm text-gray-500">Patient: {{ $invoice->patient->name ?? '—' }}</p></div><span class="badge {{ $invoice->status==='paid'?'badge-success':($invoice->status==='partial'?'badge-warning':'badge-danger') }}">{{ ucfirst($invoice->status) }}</span></div>
            <table class="admin-table mb-6"><thead><tr><th class="pl-6">Description</th><th>Qty</th><th>Unit Price</th><th class="pr-6 text-right">Total</th></tr></thead><tbody>@foreach($invoice->items as $item)<tr><td class="pl-6">{{ $item->description }}</td><td>{{ $item->quantity }}</td><td>₹{{ number_format($item->unit_price) }}</td><td class="pr-6 text-right font-medium">₹{{ number_format($item->total) }}</td></tr>@endforeach</tbody></table>
            <div class="border-t border-gray-100 pt-4 space-y-2 text-right">
                <p class="text-sm text-gray-600">Total: <span class="font-semibold text-gray-900">₹{{ number_format($invoice->total_amount) }}</span></p>
                <p class="text-sm text-emerald-600">Paid: <span class="font-semibold">₹{{ number_format($invoice->paid_amount) }}</span></p>
                <p class="text-sm text-red-600">Due: <span class="font-semibold">₹{{ number_format($invoice->due_amount) }}</span></p>
            </div>
        </div>
        <div class="space-y-6">
            @if($invoice->status !== 'paid')
            <div class="admin-card">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Record Payment</h3>
                <form method="POST" action="{{ route('admin.billing.update', $invoice) }}">@csrf @method('PUT')
                    <div class="form-group"><label class="form-label">Amount (₹)</label><input type="number" name="payment_amount" class="form-input" min="0" step="0.01" max="{{ $invoice->due_amount }}" placeholder="0.00"></div>
                    <div class="form-group"><label class="form-label">Method</label><select name="payment_method" class="form-input">@foreach(['cash','card','online','insurance'] as $m)<option value="{{ $m }}">{{ ucfirst($m) }}</option>@endforeach</select></div>
                    <button type="submit" class="btn btn-primary w-full">Record Payment</button>
                </form>
            </div>
            @endif
            <div class="admin-card">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Payment History</h3>
                @forelse($invoice->payments as $pay)
                <div class="flex justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div><p class="text-sm font-medium text-gray-800">₹{{ number_format($pay->amount) }}</p><p class="text-xs text-gray-500">{{ ucfirst($pay->method) }} · {{ $pay->paid_at?->format('M d, Y') }}</p></div>
                </div>
                @empty<p class="text-sm text-gray-400">No payments recorded.</p>@endforelse
            </div>
        </div>
    </div>
@endsection
