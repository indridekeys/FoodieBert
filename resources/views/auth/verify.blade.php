<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Security Checkpoint | FoodieBert</title>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Security Checkpoint</h2>
            <p style="color: rgba(255,255,255,0.7); text-align: center; margin-bottom: 25px; font-size: 0.9rem;">
                Identity detected: <span style="color: #C5A059; font-weight: 600;">{{ Auth::user()->matricule }}</span><br>
                Please enter your access verification code to initialize your dashboard.
            </p>

            <form action="{{ route('verification.verify') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Verification Code</label>
                    <input type="text" name="code" placeholder="Enter Demo Code (e.g. 1234)" required 
                           style="text-align: center; letter-spacing: 8px; font-size: 1.2rem; font-weight: bold;">
                </div>

                <button type="submit" class="btn-auth">Verify Identity</button>
            </form>

            <div class="switch-link">
                Incorrect account? 
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Return to Registry</a>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>