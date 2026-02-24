<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Sistem Perjalanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #FFF7ED 0%, #FFFFFF 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
        .demo-account {
            background-color: white;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-left: 3px solid var(--primary-orange);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-card shadow-lg">
                    <div class="login-header">
                        <i class="bi bi-truck-front"></i>
                        <h3 class="mb-0">Sistem Perjalanan</h3>
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
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Alamat Email
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Masukkan email Anda"
                                       required 
                                       autofocus>
                                @error('email')
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

                        <div class="demo-section">
                            <h6 class="text-muted mb-3">
                                <i class="bi bi-info-circle me-1"></i>Akun Demo
                            </h6>
                            
                            <div class="demo-account">
                                <strong class="text-danger">Admin:</strong> admin@example.com<br>
                                <small class="text-muted">Kata Sandi: 12345678</small>
                            </div>
                            
                            <div class="demo-account">
                                <strong class="text-warning">Supervisor:</strong> supervisor@example.com<br>
                                <small class="text-muted">Kata Sandi: 12345678</small>
                            </div>
                            
                            <div class="demo-account">
                                <strong class="text-info">Driver:</strong> driver@example.com<br>
                                <small class="text-muted">Kata Sandi: 12345678</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
