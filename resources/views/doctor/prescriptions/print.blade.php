<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription - {{ $prescription->patient->name ?? 'Patient' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-bottom: 4px solid #1e40af;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 2px 0;
        }

        .hospital-info {
            font-size: 13px;
            line-height: 1.8;
        }

        .content {
            padding: 30px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            background: #f0f9ff;
            color: #1e40af;
            padding: 12px 15px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-left: 4px solid #2563eb;
            margin-bottom: 15px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .medicines-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .medicines-table thead {
            background: #e0f2fe;
            border: 1px solid #bae6fd;
        }

        .medicines-table th {
            padding: 12px;
            text-align: left;
            font-weight: 700;
            color: #0369a1;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1px solid #bae6fd;
        }

        .medicines-table td {
            padding: 14px 12px;
            border: 1px solid #e0e7ff;
            font-size: 14px;
            color: #333;
        }

        .medicines-table tbody tr:nth-child(odd) {
            background: #f8fafc;
        }

        .medicines-table tbody tr:hover {
            background: #f0f9ff;
        }

        .diagnosis-notes {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            font-size: 14px;
            line-height: 1.8;
        }

        .diagnosis-notes strong {
            display: block;
            margin-bottom: 8px;
            color: #92400e;
        }

        .footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 2px solid #333;
            width: 80%;
            margin: 30px auto 8px;
        }

        .signature-label {
            font-weight: 600;
            font-size: 13px;
            color: #666;
        }

        .date-time {
            text-align: right;
            font-size: 12px;
            color: #999;
            margin-bottom: 5px;
        }

        .print-instruction {
            background: #dcfce7;
            border: 1px solid #86efac;
            padding: 12px;
            border-radius: 4px;
            font-size: 12px;
            color: #166534;
            text-align: center;
            margin-bottom: 20px;
        }

        @media print {
            body {
                background: white;
            }

            .container {
                margin: 0;
                box-shadow: none;
                max-width: 100%;
            }

            .print-instruction {
                display: none;
            }

            button {
                display: none;
            }

            .no-print {
                display: none !important;
            }

            @page {
                margin: 0.5in;
            }
        }

        .button-group {
            text-align: center;
            margin-bottom: 20px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            margin: 0 5px;
            transition: background 0.3s;
        }

        button:hover {
            background: #1d4ed8;
        }

        button.btn-secondary {
            background: #64748b;
        }

        button.btn-secondary:hover {
            background: #475569;
        }

        .empty-medicines {
            text-align: center;
            padding: 20px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>💊 PRESCRIPTION</h1>
            <div class="hospital-info">
                <p><strong>{{ $hospital['name'] }}</strong></p>
                <p>{{ $hospital['address'] }} | {{ $hospital['phone'] }}</p>
                <p>{{ $hospital['email'] }}</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Print Instructions -->
            <div class="print-instruction" style="display: none;">
                Click the Print button below or use Ctrl+P to print this prescription
            </div>

            <!-- Patient Information -->
            <div class="section">
                <div class="section-title">Patient Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Patient Name</div>
                        <div class="info-value">{{ $prescription->patient->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Patient ID</div>
                        <div class="info-value">#{{ $prescription->patient->id ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Age / Gender</div>
                        <div class="info-value">
                            @if($prescription->patient)
                                {{ $prescription->patient->age ?? 'N/A' }} / {{ ucfirst($prescription->patient->gender ?? 'N/A') }}
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Contact</div>
                        <div class="info-value">{{ $prescription->patient->phone ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Doctor Information -->
            <div class="section">
                <div class="section-title">Doctor Information</div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Doctor Name</div>
                        <div class="info-value">Dr. {{ $prescription->doctor->user->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Department</div>
                        <div class="info-value">{{ $prescription->doctor->department->name ?? 'General' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Prescription Date</div>
                        <div class="info-value">{{ $prescription->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    @if($prescription->appointment)
                    <div class="info-item">
                        <div class="info-label">Appointment Date</div>
                        <div class="info-value">{{ $prescription->appointment->appointment_date->format('d M Y') }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Diagnosis -->
            @if($prescription->diagnosis)
            <div class="section">
                <div class="section-title">Diagnosis</div>
                <div class="diagnosis-notes">
                    <strong>{{ $prescription->diagnosis }}</strong>
                </div>
            </div>
            @endif

            <!-- Medicines -->
            <div class="section">
                <div class="section-title">Prescribed Medicines</div>
                @if($prescription->items->count() > 0)
                <table class="medicines-table">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Special Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->items as $item)
                        <tr>
                            <td><strong>{{ $item->medicine->name ?? 'N/A' }}</strong></td>
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
            </div>

            <!-- Notes -->
            @if($prescription->notes)
            <div class="section">
                <div class="section-title">Additional Notes</div>
                <div class="diagnosis-notes">
                    <strong>Important Notes:</strong>
                    {{ $prescription->notes }}
                </div>
            </div>
            @endif

            <!-- Footer with Signature -->
            <div class="footer">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Patient/Guardian Signature</div>
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Doctor Signature</div>
                </div>
            </div>

            <!-- Print and Back Buttons -->
            <div class="button-group" style="margin-top: 40px;">
                <button onclick="window.print()">🖨️ Print Prescription</button>
                <button class="btn-secondary" onclick="window.history.back()">← Back</button>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus on print when opened in new window
        if (window.opener) {
            window.addEventListener('load', () => {
                // Optional: auto-print if desired
                // window.print();
            });
        }
    </script>
</body>
</html>
