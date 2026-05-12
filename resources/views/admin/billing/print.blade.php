<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} — {{ $hospital['name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── Reset & Base ──────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1a1a2e;
            background: #fff;
            font-size: 13px;
            line-height: 1.6;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Print-specific ────────────────────────── */
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .invoice-page {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            @page {
                size: A4;
                margin: 12mm 15mm;
            }
        }

        /* ── Screen layout ─────────────────────────── */
        @media screen {
            body { background: #f0f2f5; padding: 24px; }
            .invoice-page {
                max-width: 800px;
                margin: 0 auto;
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 4px 24px rgba(0,0,0,.08);
                padding: 48px;
            }
        }

        /* ── Print Toolbar ─────────────────────────── */
        .print-toolbar {
            max-width: 800px;
            margin: 0 auto 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .print-toolbar a {
            color: #6b7280;
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color .15s;
        }
        .print-toolbar a:hover { color: #3b5bdb; }
        .btn-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(135deg, #3b5bdb, #5c7cfa);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            box-shadow: 0 2px 8px rgba(59,91,219,.3);
        }
        .btn-print:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(59,91,219,.4);
        }

        /* ── Hospital Header ───────────────────────── */
        .hospital-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 3px solid #3b5bdb;
            margin-bottom: 32px;
        }
        .hospital-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .hospital-logo {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #3b5bdb, #5c7cfa);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .hospital-name {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1.2;
        }
        .hospital-tagline {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }
        .hospital-contact {
            text-align: right;
            font-size: 12px;
            color: #4b5563;
            line-height: 1.8;
        }
        .hospital-contact strong {
            color: #1a1a2e;
        }

        /* ── Invoice Title Bar ─────────────────────── */
        .invoice-title-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }
        .invoice-badge {
            font-size: 24px;
            font-weight: 700;
            color: #3b5bdb;
            letter-spacing: -0.5px;
        }
        .invoice-meta {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
        }
        .invoice-meta strong {
            color: #1a1a2e;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-top: 6px;
        }
        .status-paid { background: #d3f9d8; color: #2b8a3e; }
        .status-partial { background: #fff3bf; color: #e67700; }
        .status-unpaid { background: #ffe3e3; color: #c92a2a; }

        /* ── Patient Info ──────────────────────────── */
        .parties-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 32px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .party-label {
            font-size: 10px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .party-name {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a2e;
        }
        .party-detail {
            font-size: 12px;
            color: #4b5563;
            margin-top: 2px;
        }

        /* ── Items Table ───────────────────────────── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .items-table thead th {
            background: #f1f3f5;
            padding: 10px 14px;
            font-size: 10px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .8px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
        }
        .items-table thead th:last-child { text-align: right; }
        .items-table tbody td {
            padding: 12px 14px;
            font-size: 13px;
            border-bottom: 1px solid #e9ecef;
            color: #374151;
        }
        .items-table tbody td:last-child {
            text-align: right;
            font-weight: 600;
            color: #1a1a2e;
        }
        .items-table tbody tr:last-child td { border-bottom: none; }

        /* ── Totals ────────────────────────────────── */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 32px;
        }
        .totals-box {
            width: 280px;
        }
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 13px;
            color: #4b5563;
        }
        .totals-row.paid { color: #2b8a3e; }
        .totals-row.due { color: #c92a2a; }
        .totals-row.grand {
            border-top: 2px solid #1a1a2e;
            margin-top: 8px;
            padding-top: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
        }

        /* ── Payment History ───────────────────────── */
        .payment-history {
            margin-bottom: 32px;
        }
        .payment-history h3 {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 12px;
            color: #4b5563;
            border-bottom: 1px solid #f1f3f5;
        }

        /* ── Footer ────────────────────────────────── */
        .invoice-footer {
            border-top: 2px solid #e9ecef;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .footer-notes {
            font-size: 11px;
            color: #6b7280;
            max-width: 400px;
            line-height: 1.6;
        }
        .footer-notes strong {
            display: block;
            color: #374151;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .signature-block {
            text-align: center;
        }
        .signature-line {
            width: 160px;
            border-top: 1px solid #9ca3af;
            margin-bottom: 4px;
        }
        .signature-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ── Watermark for paid ─────────────────────── */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 80px;
            font-weight: 800;
            opacity: 0.04;
            pointer-events: none;
            text-transform: uppercase;
            letter-spacing: 8px;
        }
        .watermark.paid { color: #2b8a3e; }
        .watermark.unpaid { color: #c92a2a; }
    </style>
</head>
<body>

    <!-- ── Print Toolbar (hidden in print) ──────── -->
    <div class="print-toolbar no-print">
        <a href="{{ $backUrl ?? route('admin.billing.show', $invoice) }}">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
            Back to Invoice
        </a>
        <button class="btn-print" onclick="window.print()">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.75 12h.008v.008h-.008V12zm-2.25 0h.008v.008H16.5V12z"/></svg>
            Print / Save as PDF
        </button>
    </div>

    <!-- ── Invoice ─────────────────────────────── -->
    <div class="invoice-page" style="position: relative;">

        {{-- Watermark --}}
        @if($invoice->status === 'paid')
            <div class="watermark paid">PAID</div>
        @endif

        <!-- Hospital Header -->
        <div class="hospital-header">
            <div class="hospital-brand">
                <div class="hospital-logo">✚</div>
                <div>
                    <div class="hospital-name">{{ $hospital['name'] }}</div>
                    <div class="hospital-tagline">Healthcare Management System</div>
                </div>
            </div>
            <div class="hospital-contact">
                <strong>{{ $hospital['name'] }}</strong>
                {{ $hospital['address'] }}<br>
                📞 {{ $hospital['phone'] }}<br>
                ✉ {{ $hospital['email'] }}
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title-bar">
            <div class="invoice-badge">INVOICE</div>
            <div class="invoice-meta">
                <strong>{{ $invoice->invoice_number }}</strong><br>
                Date: {{ $invoice->created_at->format('F d, Y') }}<br>
                @if($invoice->due_date)
                    Due: {{ $invoice->due_date->format('F d, Y') }}<br>
                @endif
                <span class="status-badge status-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
            </div>
        </div>

        <!-- Parties -->
        <div class="parties-row">
            <div>
                <div class="party-label">Billed To</div>
                <div class="party-name">{{ $invoice->patient->name ?? '—' }}</div>
                @if($invoice->patient->email)
                    <div class="party-detail">{{ $invoice->patient->email }}</div>
                @endif
                @if($invoice->patient->phone)
                    <div class="party-detail">{{ $invoice->patient->phone }}</div>
                @endif
                @if($invoice->patient->address)
                    <div class="party-detail">{{ $invoice->patient->address }}</div>
                @endif
            </div>
            <div>
                <div class="party-label">Patient ID</div>
                <div class="party-name">#{{ str_pad($invoice->patient->id ?? 0, 4, '0', STR_PAD_LEFT) }}</div>
                @if($invoice->patient->blood_group)
                    <div class="party-detail">Blood Group: {{ $invoice->patient->blood_group }}</div>
                @endif
                @if($invoice->patient->gender)
                    <div class="party-detail">Gender: {{ ucfirst($invoice->patient->gender) }}</div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40px">#</th>
                    <th>Description</th>
                    <th style="width: 70px; text-align: center">Qty</th>
                    <th style="width: 110px; text-align: right">Unit Price</th>
                    <th style="width: 110px; text-align: right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: center">{{ $item->quantity }}</td>
                    <td style="text-align: right">₹{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right">₹{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <div class="totals-box">
                <div class="totals-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($invoice->total_amount, 2) }}</span>
                </div>
                @if($invoice->paid_amount > 0)
                <div class="totals-row paid">
                    <span>Paid</span>
                    <span>− ₹{{ number_format($invoice->paid_amount, 2) }}</span>
                </div>
                @endif
                <div class="totals-row {{ $invoice->due_amount > 0 ? 'due' : '' }} grand">
                    <span>{{ $invoice->due_amount > 0 ? 'Balance Due' : 'Total Paid' }}</span>
                    <span>₹{{ number_format($invoice->due_amount > 0 ? $invoice->due_amount : $invoice->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment History -->
        @if($invoice->payments->count() > 0)
        <div class="payment-history">
            <h3>Payment History</h3>
            @foreach($invoice->payments as $pay)
            <div class="payment-row">
                <span>{{ ucfirst($pay->method) }} payment — {{ $pay->paid_at?->format('M d, Y') }}</span>
                <span style="font-weight: 600; color: #2b8a3e;">₹{{ number_format($pay->amount, 2) }}</span>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-notes">
                <strong>Notes & Terms</strong>
                • This is a computer-generated invoice and does not require a physical signature.<br>
                • Payment is due by the date specified above.<br>
                • For billing inquiries, contact {{ $hospital['phone'] }} or {{ $hospital['email'] }}.
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Authorized Signature</div>
            </div>
        </div>

    </div>

</body>
</html>
