<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $transaction->razorpay_payment_id ?? $transaction->id }}</title>
    <style>
        body {
            font-family: 'Inter', 'Roboto', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #4b5563; /* Grey/Dark Grey */
            font-size: 14px;
            line-height: 1.5;
            background-color: #ffffff; /* White background to avoid grey sections */
        }
        .invoice-box {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            background-image: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), url('data:image/png;base64,{{ base64_encode(file_get_contents(public_path("world-map-bg.png"))) }}');
            background-size: cover;
            background-position: center;
            border-top: 4px solid #F58220; /* Orange/Amber top border */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
            font-size: 32px;
            line-height: 45px;
            color: #0A1172; /* Dark Blue/Navy */
            font-weight: 700;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.heading td {
            background: #0A1172; /* Dark Blue/Navy */
            color: #ffffff; /* White text */
            border-bottom: 1px solid #0A1172;
            font-weight: 600;
            padding: 10px;
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
            border-top: 2px solid #e5e7eb;
            font-weight: 700;
            font-size: 16px;
            color: #F58220; /* Orange/Amber for total */
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .badge {
            background-color: #ecfdf5; /* Light green */
            color: #047857; /* Dark green */
            padding: 4px 10px;
            border-radius: 9999px; /* Fully rounded pill */
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            border: 1px solid #34d399;
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
                                Status: <strong class="text-success">PAID</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td style="color: #0A1172;">
                                <strong style="color: #0A1172;">Billed From:</strong><br>
                                Geofence Attendance System<br>
                                <span style="color: #F58220;">{{ config('app.url', 'https://geofence_attendance.test/') }}</span><br>
                                Sumatra Sales Private Limited
                            </td>
                            <td style="color: #4b5563;">
                                <strong style="color: #0A1172;">Billed To:</strong><br>
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
                    Subscription Plan: <strong>{{ $transaction->subscription->plan_name ?? $transaction->plan->name ?? 'Custom Plan' }}</strong><br>
                    <small>Validity: {{ $transaction->subscription->duration_days ?? $transaction->plan->duration_days ?? 30 }} days</small>
                </td>
                <td>Rs. {{ number_format($transaction->amount, 2) }}</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Total: Rs. {{ number_format($transaction->amount, 2) }}</td>
            </tr>
        </table>
        
        <div style="margin: 30px -30px 20px -30px;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('empty-map.png'))) }}" alt="Service Map" style="width: 100%; height: 200px; object-fit: cover; opacity: 0.9; display: block;">
        </div>

        <div class="footer">
            <p>This is a computer-generated invoice and does not require a physical signature.</p>
            <p>Thank you for doing business with Geofence Attendance System | Sumatra Sales Private Limited.</p>
        </div>
    </div>
</body>
</html>
