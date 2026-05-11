@extends('patient.layouts.app')

@section('title', 'Reports')

@section('content')
    <section class="patient-card">
        <div class="patient-card-header">
            <h2 class="patient-card-title flex items-center gap-2">
                <div class="card-title-icon bg-amber-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M5 3a2 2 0 00-2 2v16a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2H5z"/></svg>
                </div>
                Lab reports
            </h2>
            <p class="patient-card-subtitle">View completed lab results and reports.</p>
        </div>

        @if($labOrders->isEmpty())
            <div class="patient-empty">No lab orders found yet.</div>
        @else
            <div class="space-y-3">
                @foreach($labOrders as $order)
                    <div class="patient-item" style="align-items:flex-start;">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <div class="font-semibold text-slate-900">{{ $order->labTest?->name ?? 'Lab test' }}</div>
                                <span class="patient-badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="mt-1 text-sm text-slate-600">
                                Ordered {{ optional($order->ordered_at)->format('d M Y, h:i A') }}
                                <span class="text-slate-400">·</span>
                                Doctor: {{ $order->doctor?->name ?? '—' }}
                                @if($order->completed_at)
                                    <span class="text-slate-400">·</span>
                                    Completed {{ optional($order->completed_at)->format('d M Y, h:i A') }}
                                @endif
                            </div>

                            @if($order->result)
                                <div class="mt-2 text-sm text-slate-600">
                                    <span class="font-semibold text-slate-800">Details:</span>
                                    {{ \Illuminate\Support\Str::limit($order->result, 280) }}
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0">
                            @if($order->report_file)
                                <a class="patient-pill" href="{{ route('lab-orders.report', $order) }}" target="_blank" rel="noopener">Open report</a>
                            @else
                                <span class="text-sm font-semibold text-slate-400">Pending</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection

