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
        body {
            background: linear-gradient(135deg, #FFF7ED 0%, #FFFFFF 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        body.dark-mode {
            background: linear-gradient(135deg, #121212 0%, #1E1E1E 100%);
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            border-left: 4px solid var(--primary-orange);
        }
        .login-header {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-dark) 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }
        .login-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .demo-section {
            background-color: var(--gray-50);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1.5rem;
        }
        body.dark-mode .demo-section {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .demo-account {
            background-color: white;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid var(--primary-orange);
        }
        body.dark-mode .demo-account {
            background-color: rgba(255, 255, 255, 0.05);
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 1000;
        }
        body.dark-mode .theme-toggle-login {
            background: #1E1E1E;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }
        .theme-toggle-login:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(249, 115, 22, 0.3);
        }
        .theme-toggle-login i {
            font-size: 1.5rem;
            color: #F97316;
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
