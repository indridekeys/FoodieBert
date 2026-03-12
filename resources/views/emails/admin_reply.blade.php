<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 5px; }
        .footer { font-size: 0.8rem; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Official Response</h2>
        <p>{{ $replyMessage }}</p>
        <hr>
        <div class="footer">
            <p>This is an automated response regarding your inquiry: "<strong>{{ $originalSubject }}</strong>"</p>
        </div>
    </div>
</body>
</html>