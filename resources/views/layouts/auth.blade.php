<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FX Online Pro') - Investment Platform</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- AdminUIUX Theme CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --adminuiux-content-font: 'Nunito Sans', sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: 'Nunito Sans', sans-serif;
            --adminuiux-title-font-weight: 600;
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --text-muted: #6b7280;
        }

        body {
            font-family: var(--adminuiux-content-font);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .brand-logo .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .brand-logo .logo-text {
            font-weight: 700;
            font-size: 1.5rem;
            color: #111827;
        }

        .brand-logo .logo-subtext {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .auth-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .auth-subtitle {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-floating > label {
            color: var(--text-muted);
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-outline-custom {
            border: 1px solid #d1d5db;
            color: #374151;
            border-radius: 8px;
            padding: 0.875rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .btn-outline-custom:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }

        .social-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            z-index: 5;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 1rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .text-primary-custom:hover {
            color: var(--primary-dark) !important;
            text-decoration: underline;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .pageloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            color: white;
        }

        .loader {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 576px) {
            .auth-card {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Page loader -->
    <div class="pageloader" id="pageloader">
        <div class="text-center">
            <div class="brand-logo text-white mb-3">
                <div class="logo-icon bg-white">
                    <i class="bi bi-graph-up text-primary"></i>
                </div>
                <div>
                    <div class="logo-text">FX ONLINE</div>
                    <div class="logo-subtext text-white-50">PRO COMPANY</div>
                </div>
            </div>
            <div class="loader mx-auto"></div>
        </div>
    </div>

    <main class="auth-container">
        <div class="auth-card">
            <!-- Logo -->
            <div class="brand-logo">
                <div class="logo-icon">
                    <i class="bi bi-graph-up text-white"></i>
                </div>
                <div>
                    <div class="logo-text">FX ONLINE</div>
                    <div class="logo-subtext">PRO COMPANY</div>
                </div>
            </div>

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Hide page loader
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('pageloader').style.display = 'none';
            }, 1000);
        });

        // Password toggle functionality
        function togglePassword(inputId, iconElement) {
            const passwordInput = document.getElementById(inputId);
            const icon = iconElement.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Form validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.needs-validation');
            
            Array.from(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
        });

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                setTimeout(function() {
                    bsAlert.close();
                }, 5000);
            });
        }, 100);
    </script>

    @stack('scripts')
</body>
</html>