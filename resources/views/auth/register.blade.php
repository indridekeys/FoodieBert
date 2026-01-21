<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Registry | FoodieBert</title>
    <style>
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-container input {
            width: 100%;
            padding-right: 45px; /* Space for the icon */
        }
        .toggle-icon {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s;
        }
        .toggle-icon:hover {
            color: #C5A059;
        }
        .error-alert {
            background: rgba(255, 77, 77, 0.15);
            border: 1px solid #ff4d4d;
            color: #ff4d4d;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">← Back to Home</a>
        </nav>

        <div class="auth-card">
            <h2>Empire Registry</h2>

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
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer (Diner)</option>
                        <option value="delivery_agent" {{ old('role') == 'delivery_agent' ? 'selected' : '' }}>Delivery Agent</option>
                        <option value="restaurant_owner" {{ old('role') == 'restaurant_owner' ? 'selected' : '' }}>Restaurant Owner</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Profile Portrait</label>
                    <input type="file" name="picture" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="password-container">
                        <input type="password" name="password" id="password" required>
                        <i class="fas fa-eye toggle-icon" onclick="togglePassword('password', this)"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="password-container">
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                        <i class="fas fa-eye toggle-icon" onclick="togglePassword('password_confirmation', this)"></i>
                    </div>
                </div>

                <button type="submit" class="btn-auth">Join the Empire</button>
            </form>
            
            <div class="switch-link">Already a member? <a href="{{ route('login') }}">Access HQ</a></div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>