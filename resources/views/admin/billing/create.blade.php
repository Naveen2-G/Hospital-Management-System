@extends('admin.layouts.app')
@section('title', 'New Invoice')
@section('content')
    <div class="mb-6"><a href="{{ route('admin.billing.index') }}" class="text-sm text-gray-500 hover:text-primary-600 inline-flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>Back</a><h1 class="text-2xl font-bold text-gray-900 mt-2">Create Invoice</h1></div>
    <div class="admin-card max-w-3xl">
        <form method="POST" action="{{ route('admin.billing.store') }}">@csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div class="form-group"><label class="form-label">Patient *</label><select name="patient_id" class="form-input" required><option value="">Select</option>@foreach($patients as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
                <div class="form-group"><label class="form-label">Due Date</label><input type="date" name="due_date" class="form-input"></div>
            </div>
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Invoice Items</h3>
            <div id="invoice-items">
                <div class="grid grid-cols-12 gap-3 mb-3 items-end">
                    <div class="col-span-5"><label class="form-label">Description *</label><input type="text" name="items[0][description]" class="form-input" required placeholder="e.g. Consultation Fee"></div>
                    <div class="col-span-2"><label class="form-label">Qty *</label><input type="number" name="items[0][quantity]" class="form-input" value="1" min="1" required></div>
                    <div class="col-span-3"><label class="form-label">Unit Price (₹) *</label><input type="number" name="items[0][unit_price]" class="form-input" min="0" step="0.01" required></div>
                    <div class="col-span-2"></div>
                </div>
            </div>
            <button type="button" onclick="addInvoiceItem()" class="btn btn-secondary btn-sm mb-6"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>Add Item</button>
            <div class="flex items-center gap-3 pt-6 border-t border-gray-100"><button type="submit" class="btn btn-primary">Create Invoice</button><a href="{{ route('admin.billing.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
    <script>
        let itemCount = 1;
        function addInvoiceItem() {
            const container = document.getElementById('invoice-items');
            const html = `<div class="grid grid-cols-12 gap-3 mb-3 items-end">
                <div class="col-span-5"><input type="text" name="items[${itemCount}][description]" class="form-input" required placeholder="Description"></div>
                <div class="col-span-2"><input type="number" name="items[${itemCount}][quantity]" class="form-input" value="1" min="1" required></div>
                <div class="col-span-3"><input type="number" name="items[${itemCount}][unit_price]" class="form-input" min="0" step="0.01" required placeholder="Price"></div>
                <div class="col-span-2"><button type="button" onclick="this.closest('.grid').remove()" class="btn btn-danger btn-sm w-full">Remove</button></div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
            itemCount++;
        }
    </script>
@endsection
