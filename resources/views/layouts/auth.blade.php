{{-- resources/views/layouts/auth.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sign In') - FX Online Pro</title>
    <link rel="icon" type="image/png" href="{{ asset('user/assets/img/favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Livewire Styles - Moved to top to prevent flash of unstyled content -->
    @livewireStyles
    
    <!-- Custom CSS -->
    <style>
        :root {
            --adminuiux-content-font: 'Nunito Sans', sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: 'Nunito Sans', sans-serif;
            --adminuiux-title-font-weight: 600;
            --primary-color: #7705b9;
            --primary-dark: #42005c;
            --text-muted: #6b7280;
        }

        body {
            font-family: var(--adminuiux-content-font);
            background-color: #ffffff;
            min-height: 100vh;
            margin: 0;
            padding: 0;
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

        /* Footer Styles */
        footer {
            text-align: center;
            padding: 1rem 0;
            color: var(--text-muted);
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }

        footer .footer-links a {
            color: var(--text-muted);
            margin: 0 0.5rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        footer .footer-links a:hover {
            color: var(--primary-color);
        }

        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .text-primary-custom:hover {
            color: var(--primary-dark) !important;
            text-decoration: underline;
        }

        /* Livewire-specific fixes */
        [wire\:loading], [wire\:loading\.delay], [wire\:loading\.inline-block], [wire\:loading\.inline], [wire\:loading\.block], [wire\:loading\.flex], [wire\:loading\.table], [wire\:loading\.grid] {
            display: none;
        }

        [wire\:offline] {
            display: none;
        }

        [wire\:dirty]:not([wire\:dirty\.live]) {
            display: none;
        }

        @media (max-width: 576px) {
            .brand-logo .logo-text {
                font-size: 1.25rem;
            }
            .brand-logo .logo-subtext {
                font-size: 0.75rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Page Loader -->
    {{-- <div class="pageloader" id="pageloader">
        <div class="text-center">
            <div class="brand-logo text-white mb-3">
                <div class="logo-icon bg-white">
                    <i class="bi bi-graph-up" style="color: #7705b9;"></i>
                </div>
                <div>
                    <div class="logo-text">FX ONLINE</div>
                    <div class="logo-subtext text-white-50">PRO COMPANY</div>
                </div>
            </div>
            <div class="loader mx-auto"></div>
        </div>
    </div> --}}

    <main class="d-flex flex-column min-vh-100">
        <!-- Page Content -->
        <div class="flex-grow-1 d-flex justify-content-center align-items-center py-2">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer>
            <p class="mb-2 fs-14">&copy; {{ date('Y') }} FX Online Pro. All Rights Reserved.</p>
            <div class="footer-links d-flex justify-content-center gap-3 fs-14">
                <a href="#" class="text-primary-custom">Terms & Conditions</a>
                <a href="#" class="text-primary-custom">Privacy Policy</a>
                <a href="#" class="text-primary-custom">Help</a>
                <a href="#" class="text-primary-custom">English</a>
            </div>
        </footer>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('user/assets/js/app.js') }}"></script>

    <!-- Livewire Scripts - Moved to bottom for better performance -->
    @livewireScripts

    <!-- Custom JS -->
    <script>
        // Hide page loader - ensure it doesn't interfere with Livewire
        document.addEventListener('DOMContentLoaded', function() {
            // Check if Livewire is loaded first
            if (typeof Livewire !== 'undefined') {
                Livewire.hook('component.initialized', component => {
                    document.getElementById('pageloader').style.display = 'none';
                });
            } else {
                // Fallback if Livewire isn't loaded
                setTimeout(function() {
                    document.getElementById('pageloader').style.display = 'none';
                }, 1000);
            }
        });

        // Password toggle function for Livewire forms
        function togglePassword(inputId, buttonElement) {
            const passwordInput = document.getElementById(inputId);
            const icon = buttonElement.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'bi bi-eye';
            }
            
            // Prevent form submission
            return false;
        }

        // Prevent form submission when clicking password toggle
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                if (e.target.closest('[onclick*="togglePassword"]')) {
                    e.preventDefault();
                    e.stopPropagation();
                }
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