<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 0; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td { padding: 5px; vertical-align: top; }
        table tr td:nth-child(2) { text-align: right; }
        table tr.top table td { padding-bottom: 20px; }
        table tr.top table td.title { font-size: 45px; line-height: 45px; color: #1e3a8a; }
        table tr.information table td { padding-bottom: 40px; }
        table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        table tr.details td { padding-bottom: 20px; }
        table tr.item td { border-bottom: 1px solid #eee; }
        table tr.item.last td { border-bottom: none; }
        table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
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
                                <strong>Geofence Portal</strong>
                            </td>
                            <td>
                                Invoice #: {{ $transaction->razorpay_payment_id ?? $transaction->id }}<br>
                                Created: {{ $transaction->created_at->format('F d, Y') }}<br>
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
                                Geofence Attendance Inc.<br>
                                123 Business Road<br>
                                Tech City, 10001
                            </td>
                            <td>
                                {{ $transaction->user->name }}<br>
                                {{ $transaction->user->email }}<br>
                                {{ $transaction->user->phone ?? '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Payment Method</td>
                <td>Status</td>
            </tr>
            <tr class="details">
                <td>Razorpay ({{ $transaction->currency }})</td>
                <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>
            <tr class="item">
                <td>{{ $transaction->plan->name ?? 'Subscription Plan' }} (Base)</td>
                <td>₹{{ number_format($transaction->plan->price, 2) }}</td>
            </tr>
            @if($transaction->employee_count > ($transaction->plan->employee_count ?? 10))
            <tr class="item">
                <td>Additional Employees ({{ $transaction->employee_count - ($transaction->plan->employee_count ?? 10) }} @ ₹{{ $transaction->plan->price_per_employee }})</td>
                <td>₹{{ number_format(($transaction->employee_count - ($transaction->plan->employee_count ?? 10)) * $transaction->plan->price_per_employee, 2) }}</td>
            </tr>
            @endif
            <tr class="total">
                <td></td>
                <td>Total: ₹{{ number_format($transaction->amount, 2) }}</td>
            </tr>
        </table>
        
        <p style="margin-top: 50px; text-align: center; color: #777;">
            Thank you for your business! If you have any questions, please contact support.
        </p>
    </div>
</body>
</html>
