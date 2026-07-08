<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        h2 { color: #1e3a8a; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thank you for contacting us!</h2>
        <p>Hi {{ $contact->name }},</p>
        <p>We have received your message and our team will get back to you as soon as possible.</p>
        <p><strong>Your Message Details:</strong></p>
        <ul>
            <li><strong>Subject:</strong> {{ $contact->subject ?? 'N/A' }}</li>
            <li><strong>Message:</strong><br>{{ $contact->message }}</li>
        </ul>
        <p>Best regards,<br>Geofence Portal Team</p>
        <div class="footer">
            This is an automated email. Please do not reply directly to this message.
        </div>
    </div>
</body>
</html>
