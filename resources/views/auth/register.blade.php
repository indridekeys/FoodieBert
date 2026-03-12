<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Registry | FoodieBert</title>
    <style>
        /* Force container to allow absolute positioning */
        .form-group {
            margin-bottom: 20px;
        }
        
        .password-wrapper {
            position: relative !important;
            display: flex !important;
            align-items: center !important;
            width: 100%;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 45px !important; /* Space for the icon */
            box-sizing: border-box;
        }

        .eye-toggle {
            position: absolute !important;
            right: 15px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            cursor: pointer !important;
            color: #C5A059 !important; /* Gold color */
            z-index: 999 !important; /* Force it to the front */
            font-size: 1.1rem !important;
            background: transparent !important;
            border: none !important;
        }

        .error-alert, .success-alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
        .error-alert { background: rgba(255, 77, 77, 0.15); border: 1px solid #ff4d4d; color: #ff4d4d; }
        .success-alert { background: rgba(40, 167, 69, 0.15); border: 1px solid #28a745; color: #28a745; }
    </style>
</head>
<body>@include('components.loader')
    <div class="auth-container">
        <nav class="breadcrumb">
            <a href="{{ url('/') }}">← Back to Home</a>
        </nav>

        <div class="auth-card">
            <h2 style="text-align: center; margin-bottom: 20px;">FoodieBert Registry</h2>

            @if ($errors->any())
                <div class="error-alert">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-circle-exclamation"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>Designated Role</label>
                    <select name="role" required>
                        <option value="customer">Customer (Diner)</option>
                        <option value="agent">Delivery Agent</option>
                        <option value="owner">Restaurant Owner</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Profile Portrait</label>
                    <input type="file" name="profile_photo" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" required>
                        <i class="fas fa-eye eye-toggle" onclick="togglePass('password', this)"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                        <i class="fas fa-eye eye-toggle" onclick="togglePass('password_confirmation', this)"></i>
                    </div>
                </div>

                <button type="submit" class="btn-auth">Register</button>
            </form>
            
            <div class="switch-link">Already a member? <a href="{{ route('login') }}">Login</a></div>
        </div>
    </div>

    <script>
        function togglePass(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>
</html>