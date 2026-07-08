<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #000080;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
            margin-top: 0;
        }
        .otp-box {
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            display: inline-block;
            font-size: 32px;
            font-weight: bold;
            color: #FF9933;
            letter-spacing: 5px;
            padding: 15px 30px;
            background-color: #fff4e6;
            border: 2px dashed #FF9933;
            border-radius: 8px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $name }}</strong>,</p>
            <p>We received a request to reset your password for your ProjectAttendance.com account. Please use the One-Time Password (OTP) below to proceed with resetting your password.</p>
            
            <div class="otp-box">
                <span class="otp-code">{{ $otp }}</span>
            </div>
            
            <p>This OTP is valid for <strong>15 minutes</strong>. If you did not request a password reset, please ignore this email or contact support if you have concerns.</p>
            <p>Best regards,<br>The ProjectAttendance Team<br> +916292237205 | sales@projectattendance.com</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Sumatra Sales Pvt. Ltd. | ProjectAttendance.com | All rights reserved.
        </div>
    </div>
</body>
</html>
