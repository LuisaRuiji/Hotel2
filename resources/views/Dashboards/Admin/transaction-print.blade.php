<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt - {{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .hotel-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .hotel-address {
            margin-bottom: 5px;
            color: #666;
        }
        .receipt-title {
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
            color: #333;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .invoice-details, .guest-details {
            width: 48%;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            color: #666;
        }
        .transaction-details {
            margin: 30px 0;
            border: 1px solid #eee;
            padding: 15px;
            background-color: #f9f9f9;
        }
        .amount {
            font-size: 22px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .payment-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            background-color: #e6f7ff;
            color: #0066cc;
        }
        .refund-badge {
            background-color: #ffecec;
            color: #cc0000;
        }
        .deposit-badge {
            background-color: #e6ffe6;
            color: #006600;
        }
        .signature-area {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #999;
            margin-top: 40px;
            padding-top: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                border: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Print Receipt</button>
        <button onclick="window.close()">Close</button>
    </div>
    
    <div class="receipt">
        <div class="receipt-header">
            <div class="hotel-name">Hotel Management System</div>
            <div class="hotel-address">123 Sunset Boulevard, Manila, Philippines</div>
            <div class="hotel-address">Contact: +63 (2) 123-4567 | info@hotelmanagement.com</div>
        </div>
        
        <div class="receipt-title">
            {{ ucfirst($transaction->type) }} Receipt
        </div>
        
        <div class="invoice-info">
            <div class="invoice-details">
                <div class="section-title">Invoice Information</div>
                <div class="info-row">
                    <span class="label">Invoice Number:</span> {{ $transaction->invoice_number }}
                </div>
                <div class="info-row">
                    <span class="label">Date:</span> {{ \Carbon\Carbon::parse($transaction->created_at)->format('F d, Y') }}
                </div>
                <div class="info-row">
                    <span class="label">Time:</span> {{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}
                </div>
                <div class="info-row">
                    <span class="label">Reference Number:</span> {{ $transaction->reference_number ?? 'N/A' }}
                </div>
                <div class="info-row">
                    <span class="label">Processed By:</span> {{ $transaction->user->name ?? 'System' }}
                </div>
            </div>
            
            <div class="guest-details">
                <div class="section-title">Guest Information</div>
                <div class="info-row">
                    <span class="label">Guest Name:</span> {{ $transaction->guest_name ?? 'N/A' }}
                </div>
                <div class="info-row">
                    <span class="label">Room Number:</span> {{ $transaction->room_number ?? 'N/A' }}
                </div>
                @if($transaction->booking)
                <div class="info-row">
                    <span class="label">Check-in:</span> {{ \Carbon\Carbon::parse($transaction->booking->check_in_date)->format('M d, Y') }}
                </div>
                <div class="info-row">
                    <span class="label">Check-out:</span> {{ \Carbon\Carbon::parse($transaction->booking->check_out_date)->format('M d, Y') }}
                </div>
                @endif
            </div>
        </div>
        
        <div class="transaction-details">
            <div class="section-title">Transaction Details</div>
            <div class="info-row">
                <span class="label">Transaction Type:</span> 
                <span class="payment-badge {{ $transaction->type === 'refund' ? 'refund-badge' : ($transaction->type === 'deposit' ? 'deposit-badge' : '') }}">
                    {{ ucfirst($transaction->type) }}
                </span>
            </div>
            <div class="info-row">
                <span class="label">Payment Method:</span> {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
            </div>
            <div class="info-row">
                <span class="label">Description:</span> {{ $transaction->description ?? 'No description provided' }}
            </div>
            <div class="info-row" style="margin-top: 15px;">
                <span class="label">Amount:</span> 
                <span class="amount {{ $transaction->type === 'refund' ? 'text-danger' : '' }}">
                    {{ $transaction->type === 'refund' ? '-' : '' }}₱{{ number_format($transaction->amount, 2) }}
                </span>
            </div>
        </div>
        
        <div class="signature-area">
            <div class="signature">
                <div class="signature-line">Customer Signature</div>
            </div>
            <div class="signature">
                <div class="signature-line">Authorized Signature</div>
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for choosing Hotel Management System.</p>
            <p>This receipt is computer-generated and does not require a physical signature.</p>
            <p>For inquiries, please contact our customer service at +63 (2) 123-4567.</p>
        </div>
    </div>
</body>
</html> 