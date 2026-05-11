<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Booking Receipt - #LB-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Inter', sans-serif; color: #333; line-height: 1.6; padding: 40px; }
        .receipt-container { max-width: 800px; margin: 0 auto; border: 1px solid #eee; padding: 40px; border-radius: 20px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #f3f4f6; pb-20px; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: 800; color: #0d9488; }
        .receipt-title { font-size: 28px; font-weight: 700; text-align: center; margin-bottom: 40px; color: #111; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .section-title { font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; border-bottom: 1px solid #f3f4f6; padding-bottom: 5px; }
        .info-item { margin-bottom: 12px; }
        .info-label { font-size: 11px; color: #6b7280; margin-bottom: 2px; }
        .info-value { font-size: 15px; font-weight: 600; color: #111827; }
        .amount-box { background: #f9fafb; padding: 25px; border-radius: 15px; text-align: right; margin-top: 40px; }
        .amount-label { font-size: 14px; color: #6b7280; }
        .amount-value { font-size: 32px; font-weight: 800; color: #0d9488; }
        .footer { text-align: center; margin-top: 60px; font-size: 12px; color: #9ca3af; }
        @media print {
            body { padding: 0; }
            .receipt-container { border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">
            <div class="logo">HMS HOSPITAL</div>
            <div style="text-align: right;">
                <div class="info-value">#LB-{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="info-label">Booking Date: {{ $booking->created_at->format('d M, Y') }}</div>
            </div>
        </div>

        <div class="receipt-title">LAB TEST BOOKING CONFIRMATION</div>

        <div class="grid">
            <div>
                <div class="section-title">Patient Details</div>
                <div class="info-item">
                    <div class="info-label">Patient Name</div>
                    <div class="info-value">{{ $booking->patient_name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Contact Number</div>
                    <div class="info-value">{{ $booking->phone }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $booking->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Age / Gender</div>
                    <div class="info-value">{{ $booking->age }} yrs / {{ $booking->gender }}</div>
                </div>
            </div>
            <div>
                <div class="section-title">Collection Details</div>
                <div class="info-item">
                    <div class="info-label">Preferred Date</div>
                    <div class="info-value">{{ $booking->preferred_date->format('d M, Y') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Preferred Time Slot</div>
                    <div class="info-value">{{ $booking->preferred_time_slot }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Collection Address</div>
                    <div class="info-value">
                        {{ $booking->address }},<br>
                        {{ $booking->city }}, {{ $booking->state }} - {{ $booking->pincode }}
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top: 40px; border-top: 1px solid #f3f4f6; pt: 20px;">
            <div class="section-title">Test & Payment</div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div class="info-value" style="font-size: 18px;">{{ $booking->test_name }}</div>
                    <div class="info-label">Payment Method: <span style="font-weight: 600; color: #111;">{{ strtoupper($booking->payment_method) }}</span></div>
                    <div class="info-label">Payment Status: <span style="font-weight: 600; color: #111;">{{ strtoupper($booking->payment_status) }}</span></div>
                    @if($booking->transaction_id)
                        <div class="info-label">Transaction ID: {{ $booking->transaction_id }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="amount-box">
            <div class="amount-label">Total Amount Paid/Due</div>
            <div class="amount-value">₹{{ number_format($booking->test_price, 2) }}</div>
        </div>

        <div class="footer">
            <p>This is a computer-generated confirmation for your lab test booking.</p>
            <p>HMS Hospital & Diagnostics | 123 Healthcare Way, Medical District | +1 (234) 567-890</p>
        </div>

        <div style="margin-top: 30px; text-align: center;" class="no-print">
            <button onclick="window.print()" style="padding: 12px 24px; background: #0d9488; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer;">Print Receipt</button>
        </div>
    </div>
</body>
</html>
