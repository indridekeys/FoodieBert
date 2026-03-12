<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Verify Access | FoodieBert</title>
    <style>
        .otp-input {
            letter-spacing: 8px;
            font-size: 1.8rem !important;
            text-align: center;
            font-weight: bold;
            color: #C5A059 !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(197, 160, 89, 0.3) !important;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Identity Verification</h2>
            
            <p style="color: rgba(255,255,255,0.7); text-align: center; margin-bottom: 25px;">
                Enter the 6-digit code sent to:<br>
                <span style="color: #C5A059; font-weight: bold;">{{ Auth::user()->email }}</span>
            </p>

            @if ($errors->any())
                <div style="color: #ff4d4d; margin-bottom: 15px; font-size: 0.85rem;">
                    @foreach ($errors->all() as $error)
                        <div><i class="fas fa-exclamation-circle"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('verify.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                
                <div class="form-group">
                    <label>Security Code</label>
                    <input type="text" 
                           name="otp" 
                           class="otp-input" 
                           placeholder="000000" 
                           required 
                           maxlength="6">
                </div>

                <button type="submit" class="btn-auth">Verify Account</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <form action="{{ route('verify.resend') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#C5A059; cursor:pointer; font-size:0.8rem; text-decoration:underline;">
                        Didn't get a code? Resend Email
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>