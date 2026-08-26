<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subscription Expiring</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(to right, #FF9933, #FFFFFF, #138808);
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #000080;
        }
        .header h1 {
            margin: 0;
            color: #000080;
            font-size: 24px;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.8);
        }
        .content {
            padding: 30px;
            line-height: 1.6;
        }
        .content h2 {
            color: #FF9933;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .details-table th {
            color: #000080;
            width: 40%;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            background-color: #FF9933;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            background-color: #f9f9f9;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Smart Geofence Project Attendance System</h1>
        </div>
        <div class="content">
            <h2>Important: Your Subscription is Expiring Soon</h2>
            <p>Dear {{ $user->business_name }},</p>
            <p>This is a gentle reminder that your current subscription is set to expire in <strong>3 days</strong> (on {{ $subscription->expires_at->format('M d, Y') }}).</p>
            
            <p>To avoid any interruption in your services, please renew or upgrade your subscription before it expires.</p>
            
            <table class="details-table">
                <tr>
                    <th>Current Plan</th>
                    <td>{{ $subscription->plan_name }}</td>
                </tr>
                <tr>
                    <th>Expiry Date</th>
                    <td>{{ $subscription->expires_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <div class="btn-container">
                <a href="{{ route('pricing.select') }}" class="btn" style="display: inline-block; background-color: #FF9933; color: #ffffff !important; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold; font-size: 16px;">Renew / Upgrade Now</a>
            </div>

            <p style="margin-top: 20px;">If you have any questions or need assistance, feel free to reach out to our support team.</p>
            <p>Thanks,<br><strong>Smart Geofence Project Attendance System Team</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Smart Geofence Project Attendance System. All rights reserved.
        </div>
    </div>
</body>
</html>
