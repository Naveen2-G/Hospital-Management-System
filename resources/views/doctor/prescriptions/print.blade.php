<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription - {{ $prescription->patient->name ?? 'Patient' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1a1a2e;
            background: #f5f5f5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }


        .page {
            max-width: 850px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        @media screen {
            .page {
                margin: 20px auto;
                padding: 40px;
            }
        }

        @media print {
            body {
                background: white;
            }
            .page {
                max-width: 100%;
                margin: 0;
                padding: 40px;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: A4;
                margin: 12mm 15mm;
            }
        }

        /* ── Header: Logo + Name + Contact ────────── */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #3b5bdb;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 16px;
            flex: 1;
        }

        .logo-box {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b5bdb, #5c7cfa);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(59, 91, 219, 0.2);
        }

        .logo-box svg {
            width: 32px;
            height: 32px;
            color: white;
        }

        .brand-text h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #1a1a2e;
            line-height: 1.1;
        }

        .brand-text p {
            margin: 2px 0 0;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #6b7280;
        }

        .contact-section {
            text-align: right;
            flex-shrink: 0;
        }

        .contact-section p {
            margin: 4px 0;
            font-size: 12px;
            line-height: 1.5;
            color: #4b5563;
        }

        .contact-section strong {
            color: #1a1a2e;
        }

        /* ── Prescription Title ────────────────────── */
        .prescription-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 24px 0 20px;
        }

        .prescription-title h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: -0.5px;
        }

        .prescription-meta {
            text-align: right;
            font-size: 12px;
            color: #6b7280;
        }

        .prescription-meta strong {
            color: #1a1a2e;
        }

        /* ── Patient Details ──────────────────────── */
        .section {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 12px 0 10px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 12px;
        }

        .patient-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px 24px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 10px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 500;
            color: #1a1a2e;
        }

        /* ── Diagnosis Box ────────────────────────── */
        .diagnosis-box {
            background: #f0f4ff;
            border-left: 4px solid #3b5bdb;
            padding: 12px 16px;
            margin: 16px 0;
            border-radius: 4px;
        }

        .diagnosis-label {
            font-size: 10px;
            font-weight: 700;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .diagnosis-text {
            font-size: 14px;
            color: #1a1a2e;
            line-height: 1.6;
        }

        /* ── Medicines Table ──────────────────────── */
        .medicines-table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
            background: white;
        }

        .medicines-table thead {
            background: #f8fafc;
            border-bottom: 2px solid #3b5bdb;
        }

        .medicines-table th {
            padding: 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #1a1a2e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .medicines-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
            color: #374151;
        }

        .medicines-table tbody tr:last-child td {
            border-bottom: none;
        }

        .medicine-name {
            font-weight: 600;
            color: #1a1a2e;
        }

        .empty-medicines {
            text-align: center;
            padding: 20px;
            color: #9ca3af;
            font-style: italic;
            font-size: 13px;
        }

        /* ── Notes Section ────────────────────────── */
        .notes-box {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 12px 16px;
            margin: 16px 0;
            border-radius: 4px;
        }

        .notes-label {
            font-size: 10px;
            font-weight: 700;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .notes-text {
            font-size: 13px;
            color: #78350f;
            line-height: 1.6;
        }

        /* ── Signature Section ────────────────────── */
        .signature-section {
            margin-top: 32px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #1a1a2e;
            width: 160px;
            height: 1px;
            margin: 0 auto 8px;
        }

        .signature-label {
            font-size: 10px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Toolbar (No Print) ────────────────────── */
        .toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .toolbar-info {
            font-size: 13px;
            color: #6b7280;
        }

        .toolbar-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-print {
            background: linear-gradient(135deg, #3b5bdb, #5c7cfa);
            color: white;
            box-shadow: 0 2px 8px rgba(59, 91, 219, 0.2);
        }

        .btn-print:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(59, 91, 219, 0.3);
        }

        .btn-back {
            background: #e5e7eb;
            color: #1a1a2e;
        }

        .btn-back:hover {
            background: #d1d5db;
        }

        @media screen {
            body {
                padding-top: 64px;
            }
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .contact-section {
                text-align: left;
            }

            .patient-details {
                grid-template-columns: 1fr;
            }

            .signature-section {
                grid-template-columns: 1fr;
            }

            .prescription-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .prescription-meta {
                text-align: left;
            }
        }
    </style>
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <div class="toolbar-info">Prescription for {{ $prescription->patient->name ?? 'Patient' }}</div>
        <div class="toolbar-buttons">
            <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
            <button class="btn btn-back" onclick="window.history.back()">← Back</button>
        </div>
    </div>

    <div class="page">
        <!-- Header: Logo + Name + Contact -->
        <header class="header">
            <div class="brand-section">
                <div class="logo-box">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>{{ $hospital['name'] }}</h1>
                    <p>Hospital Management System</p>
                </div>
            </div>

            <div class="contact-section">
                <p><strong>{{ $hospital['address'] }}</strong></p>
                <p>{{ $hospital['phone'] }} | {{ $hospital['email'] }}</p>
            </div>
        </header>

        <!-- Prescription Title -->
        <div class="prescription-title">
            <h2>Prescription</h2>
            <div class="prescription-meta">
                <div><strong>Rx #{{ $prescription->id }}</strong></div>
                <div>{{ $prescription->created_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Patient Details -->
        <section class="section">
            <div class="section-title">Patient Information</div>
            <div class="patient-details">
                <div class="detail-item">
                    <span class="detail-label">Patient Name</span>
                    <span class="detail-value">{{ $prescription->patient->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Patient ID</span>
                    <span class="detail-value">#{{ $prescription->patient->id ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Age / Gender</span>
                    <span class="detail-value">
                        @if($prescription->patient)
                            {{ $prescription->patient->dob?->age ?? 'N/A' }} / {{ ucfirst($prescription->patient->gender ?? 'N/A') }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Blood Group</span>
                    <span class="detail-value">{{ $prescription->patient->blood_group ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone</span>
                    <span class="detail-value">{{ $prescription->patient->phone ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Date of Birth</span>
                    <span class="detail-value">{{ $prescription->patient->dob?->format('d M Y') ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Address</span>
                    <span class="detail-value">{{ $prescription->patient->address ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Emergency Contact</span>
                    <span class="detail-value">{{ $prescription->patient->emergency_contact_name ?? 'N/A' }}{{ $prescription->patient->emergency_contact ? ' · ' . $prescription->patient->emergency_contact : '' }}</span>
                </div>
            </div>
        </section>

        <!-- Doctor Details -->
        <section class="section">
            <div class="section-title">Doctor Information</div>
            <div class="patient-details">
                <div class="detail-item">
                    <span class="detail-label">Doctor Name</span>
                    <span class="detail-value">Dr. {{ $prescription->doctor->user->name ?? 'N/A' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Appointment Date</span>
                    <span class="detail-value">{{ $prescription->appointment?->appointment_date?->format('d M Y') ?? 'Not linked' }}</span>
                </div>
            </div>
        </section>

        <!-- Diagnosis -->
        @if($prescription->diagnosis)
        <section class="section">
            <div class="diagnosis-box">
                <div class="diagnosis-label">Diagnosis</div>
                <div class="diagnosis-text">{{ $prescription->diagnosis }}</div>
            </div>
        </section>
        @endif

        <!-- Medicines -->
        <section class="section">
            <div class="section-title">Prescribed Medicines</div>
            @if($prescription->items->count() > 0)
                <table class="medicines-table">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->items as $item)
                        <tr>
                            <td class="medicine-name">{{ $item->medicine->name ?? 'N/A' }}</td>
                            <td>{{ $item->dosage ?? '—' }}</td>
                            <td>{{ $item->frequency ?? '—' }}</td>
                            <td>{{ $item->duration ?? '—' }}</td>
                            <td>{{ $item->instructions ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-medicines">No medicines prescribed</div>
            @endif
        </section>

        <!-- Notes -->
        @if($prescription->notes)
        <section class="section">
            <div class="notes-box">
                <div class="notes-label">Additional Notes</div>
                <div class="notes-text">{{ $prescription->notes }}</div>
            </div>
        </section>
        @endif

        <!-- Signatures -->
        <section class="section">
            <div class="section-title">Signatures</div>
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Patient / Guardian</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Doctor</div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
