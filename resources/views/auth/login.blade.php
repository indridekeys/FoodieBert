<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Login | Empire Command</title>
    <style>
        .error-alert, .success-alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .error-alert { background: rgba(255, 77, 77, 0.15); border: 1px solid #ff4d4d; color: #ff4d4d; }
        .success-alert { background: rgba(40, 167, 69, 0.15); border: 1px solid #28a745; color: #28a745; }
        
        .input-hint {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.65rem;
            margin-top: 5px;
            display: block;
        }

        input:focus {
            border-color: #C5A059 !important;
            outline: none;
            box-shadow: 0 0 5px rgba(197, 160, 89, 0.5);
        }

        /* Essential: This ensures the eye icon is visible and clickable */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 45px !important; /* Make room for the eye */
        }

        .toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #C5A059; /* Gold color to match your theme */
            z-index: 10;
            font-size: 1.1rem;
            transition: opacity 0.3s;
        }

        .toggle-icon:hover {
            opacity: 0.8;
        }

       
    </style>
</head>
<body>@include('components.loader')
    <div class="auth-container">
        <nav class="breadcrumb">
            <a href="{{ url('/') }}">← Back to Home</a>
        </nav>

        <div class="auth-card">
            <div style="text-align: center; margin-bottom: 20px;">
                <h2 style="margin-bottom: 5px;">Command Access</h2>
                <p style="font-size: 0.75rem; color: #C5A059; letter-spacing: 1px; text-transform: uppercase;">Identity Verification</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your registered email" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Matricule Number</label>
                    <input type="text" name="matricule" value="{{ old('matricule') }}" placeholder="E.g. FB-2026-001">
                    <span class="input-hint">* Required for Agents, Owners, and Admins</span>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-key"></i> Access Key (Password)</label>
                    <div class="password-container">
                        <input type="password" name="password" id="login-password" placeholder="••••••••" required>
                        <i class="fas fa-eye toggle-icon" id="toggleLoginPassword"></i>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <label style="font-size: 0.75rem; color: rgba(255,255,255,0.7); cursor: pointer; display: flex; align-items: center; gap: 5px;">
                        <input type="checkbox" name="remember"> Remember Device
                    </label>
                    <a href="#" style="font-size: 0.75rem; color: #C5A059; text-decoration: none;">Forgot Key?</a>
                </div>

                <button type="submit" class="btn-auth">Initialize Login</button>
            </form>

            <div class="switch-link">
                New Citizen? <a href="{{ route('register') }}">Join the Registry</a>
            </div>
        </div>
    </div>

    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#toggleLoginPassword');
            const passwordField = document.querySelector('#login-password');

            if (togglePassword) {
                togglePassword.addEventListener('click', function () {
                    // Toggle the type attribute
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                    
                    // Toggle the icon (Eye vs Eye Slash)
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Loader logic
            const loginForm = document.querySelector('form');
            if(loginForm) {
                loginForm.addEventListener('submit', function() {
                    document.getElementById('login-loader').style.display = 'flex';
                });
            }
        });

        window.addEventListener('load', function() {
            document.getElementById('login-loader').style.display = 'none';
        });
    </script>
</body>
</html>