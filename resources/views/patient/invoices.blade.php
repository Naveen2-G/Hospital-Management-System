@extends('patient.layouts.app')

@section('title', 'Invoices')

@section('content')
    <section class="patient-card">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-rose-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2-1.343-2-3-2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14c-4 0-7 2-7 4v2h14v-2c0-2-3-4-7-4z"/></svg>
                </div>
                Invoices
            </h2>
            <p class="patient-card-subtitle">Billing details and payment status.</p>
        </div>

        @if($invoices->isEmpty())
            <div class="patient-empty">No invoices found yet.</div>
        @else
            <div class="overflow-x-auto">
                <table class="patient-table">
                    <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $inv)
                        <tr>
                            <td>{{ $inv->invoice_number ?? ('#' . $inv->id) }}</td>
                            <td>₹{{ number_format((float) $inv->total_amount, 2) }}</td>
                            <td>₹{{ number_format((float) $inv->paid_amount, 2) }}</td>
                            <td>₹{{ number_format((float) $inv->due_amount, 2) }}</td>
                            <td><span class="patient-badge badge-{{ $inv->status }}">{{ ucfirst($inv->status) }}</span></td>
                            <td class="text-right">
                                @if((float) $inv->due_amount > 0)
                                    <a href="{{ route('patient.invoices.payment.create', $inv) }}" class="patient-pill patient-pill-dark">Pay now</a>
                                @else
                                    <span class="text-sm font-semibold text-emerald-700">Paid</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection

