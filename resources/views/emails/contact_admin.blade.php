<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        h2 { color: #d97706; }
        .details { background-color: #f9f9f9; padding: 15px; border-radius: 4px; }
        .footer { margin-top: 20px; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Inquiry Received</h2>
        <p>A new message has been submitted through the Geofence Portal contact form.</p>
        
        <div class="details">
            <p><strong>Name:</strong> {{ $contact->name }}</p>
            <p><strong>Email:</strong> {{ $contact->email }}</p>
            <p><strong>Phone:</strong> {{ $contact->phone ?? 'N/A' }}</p>
            <p><strong>Subject:</strong> {{ $contact->subject ?? 'N/A' }}</p>
            <p><strong>Message:</strong></p>
            <p>{{ $contact->message }}</p>
        </div>
        
        <p>You can view this message in the Superadmin Dashboard.</p>
        
        <div class="footer">
            System Notification | Geofence Attendance
        </div>
    </div>
</body>
</html>
