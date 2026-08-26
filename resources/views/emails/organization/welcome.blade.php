<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome</title>
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
        .plans-container {
            margin-top: 20px;
        }
        .plan-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fcfcfc;
            border-left: 4px solid #138808;
        }
        .plan-name {
            font-size: 18px;
            font-weight: bold;
            color: #000080;
        }
        .plan-price {
            font-size: 16px;
            color: #138808;
            font-weight: bold;
            margin-top: 5px;
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
            <h2>Welcome, {{ $user->business_name }}!</h2>
            <p>We are thrilled to have your organization on board. To get the most out of our platform, we invite you to explore our subscription options.</p>
            
            <p>You can start with a <strong>Trial Pack</strong> to experience our features or choose a <strong>Main Subscription</strong> that best fits your needs. Best of all, you can customize your subscription according to your organization's unique requirements!</p>
            
            <div class="plans-container">
                <h3 style="color: #000080;">Available Plans:</h3>
                @foreach($plans as $plan)
                <div class="plan-card">
                    <div class="plan-name">{{ $plan->name }} @if($plan->is_popular) <span style="font-size:12px; color:#FF9933;">(Popular)</span> @endif</div>
                    <div class="plan-price">₹{{ $plan->price }} / {{ $plan->duration_days }} days</div>
                    <p style="margin-top: 10px; font-size: 14px; color: #555;">{{ $plan->description }}</p>
                </div>
                @endforeach
            </div>

            <div class="btn-container">
                <a href="{{ route('pricing.select') }}" class="btn" style="display: inline-block; background-color: #FF9933; color: #ffffff !important; text-decoration: none; padding: 12px 25px; border-radius: 4px; font-weight: bold; font-size: 16px;">Explore & Customize Subscription</a>
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
