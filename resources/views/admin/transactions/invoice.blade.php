<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $transaction->razorpay_payment_id ?? $transaction->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 30px;
            line-height: 45px;
            color: #1a2639;
            font-weight: bold;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .badge {
            background-color: #d1fae5;
            color: #065f46;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                INVOICE
                            </td>
                            <td>
                                Invoice #: {{ $transaction->razorpay_payment_id ?? $transaction->id }}<br>
                                Created: {{ $transaction->created_at->format('F d, Y') }}<br>
                                Status: <span class="badge">PAID</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Billed From:</strong><br>
                                Geofence Attendance System<br>
                                (A product of Tech Innovations)<br>
                                GSTIN: 27AAAAA0000A1Z5<br>
                                contact@geofence-attendance.test
                            </td>
                            <td>
                                <strong>Billed To:</strong><br>
                                {{ $user->business_name ?? $user->name }}<br>
                                {{ $user->name }}<br>
                                {{ $user->email }}<br>
                                {{ $user->phone }}<br>
                                @if($user->gst_number)
                                GSTIN: {{ $user->gst_number }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td>Reference</td>
            </tr>

            <tr class="details">
                <td>Razorpay Gateway</td>
                <td>{{ $transaction->razorpay_payment_id ?? 'N/A' }}</td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Amount</td>
            </tr>

            <tr class="item last">
                <td>
                    Subscription Plan: <strong>{{ $transaction->plan->name ?? 'Custom Plan' }}</strong><br>
                    <small>Validity: {{ $transaction->plan->duration_days ?? 30 }} days</small>
                </td>
                <td>₹{{ number_format($transaction->amount, 2) }}</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Total: ₹{{ number_format($transaction->amount, 2) }}</td>
            </tr>
        </table>
        
        <div class="footer">
            <p>This is a computer-generated invoice and does not require a physical signature.</p>
            <p>Thank you for doing business with Geofence Attendance System.</p>
        </div>
    </div>
</body>
</html>
