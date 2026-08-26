<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subscription Expiring Alert</title>
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
            color: #138808;
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
            <h2>Organization Subscription Expiring Soon</h2>
            <p>An organization's subscription is expiring in exactly <strong>3 days</strong>.</p>
            
            <table class="details-table">
                <tr>
                    <th>Business Name</th>
                    <td>{{ $user->business_name }}</td>
                </tr>
                <tr>
                    <th>Owner Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->phone }}</td>
                </tr>
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
                <a href="{{ route('superadmin.organizations.index') }}" class="btn" style="display: inline-block; background-color: #FF9933; color: #ffffff !important; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold; font-size: 16px;">View in Admin Panel</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Smart Geofence Project Attendance System. All rights reserved.
        </div>
    </div>
</body>
</html>
