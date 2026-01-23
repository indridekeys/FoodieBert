<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FoodieBert | Account Authentication</title>
    <link rel="stylesheet" href="{{ asset('css/Alldashboards.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body style="display: flex; justify-content: center; align-items: center; background: var(--primary-blue);">

    <div class="modal-content" style="display: block; width: 400px; text-align: center; border-radius: 30px; box-shadow: 0 20px 50px rgba(0,0,0,0.5);">
        <h2 style="font-family: 'Playfair Display'; color: var(--primary-blue); margin-bottom: 10px;">Security Check</h2>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 30px;">
            Please enter the 6-digit code sent to <strong>{{ Auth::user()->email }}</strong> to activate your citizen status.
        </p>

        <form action="{{ route('verify.otp') }}" method="POST">
            @csrf
            <div style="margin-bottom: 25px;">
                <input type="text" name="otp" placeholder="000000" maxlength="6" 
                       style="font-size: 2rem; letter-spacing: 15px; text-align: center; font-weight: 700; color: var(--accent-gold);" 
                       class="form-control" required autofocus>
            </div>
            
            <button type="submit" class="btn-primary" style="padding: 15px; font-size: 1rem;">
                Activate Account
            </button>
        </form>

        <div style="margin-top: 20px;">
            <a href="#" style="color: var(--accent-gold); font-size: 0.75rem; text-decoration: none;">Resend Code</a>
        </div>
    </div>

</body>
</html>