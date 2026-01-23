<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <title>Login | Empire Command</title>
</head>
<body>
    <div class="auth-container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">← Back to Home</a>
        </nav>

        <div class="auth-card">
            <h2>Command Access</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Matricule Number</label>
                    <input type="text" name="matricule" placeholder="E.g. FB-2026-001">
                    <small style="color:rgba(255,255,255,0.4); font-size:0.6rem;">* Required for Partners/Admins</small>
                </div>

                <div class="form-group">
                    <label>Access Key (Password)</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn-auth">Initialize Login</button>
            </form>
            <div class="switch-link">New Citizen? <a href="{{ route('register') }}">Join Registry</a></div>
        </div>
    </div>
</body>
</html>