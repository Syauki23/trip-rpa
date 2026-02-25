<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - PT RPA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/darkmode.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #FFF5F0 0%, #FFEDE5 50%, #FFF9F5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 16px;
            overflow: hidden;
        }
        
        body.dark-mode {
            background: linear-gradient(135deg, #0F0F0F 0%, #1A1A1A 50%, #121212 100%);
        }
        
        /* Keyframe Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 0.6;
            }
            100% {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        @keyframes glowPulse {
            0%, 100% {
                box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.08);
            }
            50% {
                box-shadow: 0 0 0 6px rgba(249, 115, 22, 0.12);
            }
        }
        
        .login-card {
            max-width: 380px;
            width: 100%;
            border: none;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(249, 115, 22, 0.12), 0 2px 8px rgba(0, 0, 0, 0.04);
            animation: fadeInUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        body.dark-mode .login-card {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5), 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        
        .login-header {
            background: linear-gradient(135deg, #FB923C 0%, #F97316 100%);
            color: white;
            padding: 40px 24px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: iconPulse 3s ease-in-out infinite;
        }
        
        .login-header i {
            font-size: 56px;
            margin-bottom: 16px;
            opacity: 0.95;
            display: inline-block;
            animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s backwards;
            position: relative;
            z-index: 1;
        }
        
        .login-header h3 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
            animation: fadeInUp 0.5s ease 0.3s backwards;
            position: relative;
            z-index: 1;
        }
        
        .login-header p {
            font-size: 14px;
            opacity: 0.92;
            font-weight: 400;
            animation: fadeInUp 0.5s ease 0.4s backwards;
            position: relative;
            z-index: 1;
        }
        
        .card-body {
            padding: 32px 24px 36px !important;
            background: white;
            animation: fadeInUp 0.5s ease 0.3s backwards;
        }
        
        body.dark-mode .card-body {
            background: #1E1E1E;
        }
        
        .alert {
            border-radius: 16px;
            border: none;
            padding: 14px 18px;
            font-size: 14px;
            margin-bottom: 24px;
            animation: fadeInUp 0.4s ease;
        }
        
        .alert-danger {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        body.dark-mode .alert-danger {
            background: rgba(220, 38, 38, 0.15);
            color: #FCA5A5;
        }
        
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        body.dark-mode .form-label {
            color: #D1D5DB;
        }
        
        .form-label i {
            color: #F97316;
            font-size: 16px;
            animation: fadeInUp 0.3s ease;
        }
        
        .input-wrapper {
            position: relative;
            margin-bottom: 24px;
        }
        
        .form-control {
            border: 2px solid #E5E7EB;
            border-radius: 16px;
            padding: 14px 18px;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #F9FAFB;
            width: 100%;
        }
        
        body.dark-mode .form-control {
            background: #2A2A2A;
            border-color: #3A3A3A;
            color: #E5E7EB;
        }
        
        .form-control:focus {
            border-color: #FB923C;
            background: #FFF7ED;
            outline: none;
            animation: glowPulse 1.5s ease-in-out;
            transform: translateY(-2px);
        }
        
        body.dark-mode .form-control:focus {
            background: #2A2A2A;
            border-color: #FB923C;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.15);
        }
        
        .form-control::placeholder {
            color: #9CA3AF;
            font-size: 14px;
        }
        
        .form-check {
            padding-left: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }
        
        .form-check-input {
            width: 22px;
            height: 22px;
            border: 2px solid #D1D5DB;
            border-radius: 7px;
            cursor: pointer;
            margin: 0;
            transition: all 0.2s ease;
        }
        
        .form-check-input:checked {
            background-color: #F97316;
            border-color: #F97316;
            transform: scale(1.1);
        }
        
        .form-check-label {
            font-size: 14px;
            color: #6B7280;
            cursor: pointer;
            margin: 0;
            font-weight: 500;
        }
        
        body.dark-mode .form-check-label {
            color: #9CA3AF;
        }
        
        /* Material Ripple Button */
        .btn-primary {
            background: linear-gradient(135deg, #FB923C 0%, #F97316 100%);
            border: none;
            border-radius: 16px;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(249, 115, 22, 0.4);
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }
        
        .btn-primary:active {
            transform: translateY(-1px);
        }
        
        .btn-primary:active::before {
            width: 300px;
            height: 300px;
            transition: width 0s, height 0s;
        }
        
        .theme-toggle-login {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s backwards;
        }
        
        body.dark-mode .theme-toggle-login {
            background: #2A2A2A;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
        }
        
        .theme-toggle-login:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 6px 24px rgba(249, 115, 22, 0.25);
        }
        
        .theme-toggle-login:active {
            transform: scale(0.95);
        }
        
        .theme-toggle-login i {
            font-size: 22px;
            color: #F97316;
            transition: transform 0.3s ease;
        }
        
        /* Mobile optimization */
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }
            
            .login-card {
                max-width: 360px;
                border-radius: 24px;
            }
            
            .login-header {
                padding: 36px 20px 28px;
            }
            
            .login-header i {
                font-size: 48px;
            }
            
            .login-header h3 {
                font-size: 22px;
            }
            
            .card-body {
                padding: 28px 20px 32px !important;
            }
            
            .form-control {
                padding: 13px 16px;
                font-size: 14px;
                border-radius: 14px;
            }
            
            .btn-primary {
                padding: 15px 20px;
                font-size: 15px;
                border-radius: 14px;
            }
            
            .theme-toggle-login {
                width: 44px;
                height: 44px;
                top: 16px;
                right: 16px;
            }
            
            .theme-toggle-login i {
                font-size: 20px;
            }
        }
        
        /* Extra smooth transitions */
        * {
            -webkit-tap-highlight-color: transparent;
        }
        
        .form-control,
        .btn-primary,
        .form-check-input,
        .theme-toggle-login {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body class="light-mode" id="themeBody">
    <button class="theme-toggle-login" onclick="toggleTheme()" title="Toggle Dark Mode">
        <i class="bi bi-moon-fill" id="themeIconLogin"></i>
    </button>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-card shadow-lg">
                    <div class="login-header">
                        <i class="bi bi-truck-front"></i>
                        <h3 class="mb-0">PT RPA</h3>
                        <p class="mb-0 mt-2 opacity-90">Masuk ke akun Anda</p>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Oops!</strong> {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="bi bi-person me-1"></i>Username
                                </label>
                                <input type="text" 
                                       class="form-control @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username') }}" 
                                       placeholder="Masukkan username Anda"
                                       required 
                                       autofocus>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock me-1"></i>Kata Sandi
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Masukkan kata sandi Anda"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Theme Toggle Script -->
    <script>
        // Apply theme function
        function applyTheme(theme) {
            const body = document.getElementById('themeBody');
            if (body) {
                body.className = theme;
            }
            updateThemeIcon(theme);
        }
        
        // Load theme from localStorage on page load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light-mode';
            applyTheme(savedTheme);
        })();
        
        // Toggle theme function
        function toggleTheme() {
            const body = document.getElementById('themeBody');
            const currentTheme = body.className;
            const newTheme = currentTheme === 'light-mode' ? 'dark-mode' : 'light-mode';
            
            // Apply new theme with smooth transition
            applyTheme(newTheme);
            
            // Save to localStorage
            localStorage.setItem('theme', newTheme);
            
            // Add subtle animation feedback
            body.style.transition = 'background-color 0.25s ease, color 0.25s ease';
        }
        
        // Update theme icon
        function updateThemeIcon(theme) {
            const themeIconLogin = document.getElementById('themeIconLogin');
            
            if (theme === 'dark-mode') {
                if (themeIconLogin) {
                    themeIconLogin.className = 'bi bi-sun-fill';
                }
            } else {
                if (themeIconLogin) {
                    themeIconLogin.className = 'bi bi-moon-fill';
                }
            }
        }
    </script>
</body>
</html>
