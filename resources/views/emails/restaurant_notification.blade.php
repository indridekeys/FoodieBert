<!DOCTYPE html>
<html>
<head>
    <style>
        .email-wrapper {
            background-color: #f4f4f4;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .email-card {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            border-top: 8px solid #001f3f; /* Navy Blue */
            border-bottom: 4px solid #D4AF37; /* Gold */
            padding: 40px;
            text-align: center;
        }
        .status-badge {
            color: #FF5C5C; /* Light Red */
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 14px;
        }
        .btn-download {
            display: inline-block;
            background-color: #001f3f;
            color: #D4AF37 !important;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer-text {
            font-size: 12px;
            color: #999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-card">
            <div class="status-badge">Official Registry Notification</div>
            
            <h1 style="color: #001f3f;">Welcome, {{ $restaurant->owner_name }}!</h1>
            
            <p style="color: #555; line-height: 1.6;">
                We are pleased to inform you that <strong>{{ $restaurant->name }}</strong> 
                has been successfully registered in our system.
            </p>

            <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <p style="margin: 5px 0;"><strong>Category:</strong> {{ $restaurant->category }}</p>
                <p style="margin: 5px 0; color: #001f3f;"><strong>Matricule:</strong> {{ $restaurant->matricule }}</p>
            </div>

            <p style="color: #555;">
                Attached to this email, you will find your official **Registration Certificate**. 
                Please keep this document for your records.
            </p>

            <p class="footer-text">
                This is an automated message from the Empire Administrative Portal.<br>
                Location: {{ $restaurant->location }}
            </p>
        </div>
    </div>
</body>
</html>