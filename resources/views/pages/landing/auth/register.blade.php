<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sayur On Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .register-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .logo {
            width: 200px;
            margin: 0 auto 2rem;
            display: block;
        }
        .form-control {
            background-color: white;
            border: 1px solid #ced4da;
            color: #333;
            padding: 0.8rem;
        }
        .form-control:focus {
            background-color: white;
            border-color: #4CAF50;
            color: #333;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        .btn-primary {
            background-color: #4CAF50;
            border: none;
            padding: 0.8rem;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #45a049;
        }
        .btn-login {
            background-color: transparent;
            border: 1px solid #45A65F;
            color: #45A65F;
            padding: 0.8rem;
            width: 100%;
        }
        .btn-login:hover {
            background-color: #45A65F;
            color: white;
        }
        .password-field {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #6c757d;
            cursor: pointer;
        }
        .toggle-password:hover {
            color: #45A65F;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <img src="{{ $assets->where('name', 'logo-mark')->first()->image ?? asset('assets/landing/images/logo-balian.png') }}" alt="Logo" class="logo">
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-3">
                <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" required autofocus>
                @error('name')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
                @error('email')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="password-field">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                        <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-danger mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <div class="password-field">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                        <i class="fa-regular fa-eye" id="toggleConfirmIcon"></i>
                    </button>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">REGISTER</button>
                <a href="{{ route('landing.auth.login') }}" class="btn btn-login">LOG IN</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(inputId === 'password' ? 'togglePasswordIcon' : 'toggleConfirmIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
