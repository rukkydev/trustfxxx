
<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'CryptoWallet - Your Digital Investment Platform')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Heroicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.css">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    
    <!-- Cryptoon Base CSS (if you want to keep some original styles) -->
    <link rel="stylesheet" href="{{ asset('user/assets/css/cryptoon.style.min.css') }}">
    
    <!-- Custom Mobile Crypto Styles -->
    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Nunito Sans', system-ui, -apple-system, sans-serif !important;
            background-color: #ffffff !important;
            color: #0f172a !important;
            line-height: 1.6;
            padding-bottom: 80px;
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Override Cryptoon theme classes */
        .theme-orange,
        #cryptoon-layout {
            background-color: #ffffff !important;
            color: #0f172a !important;
        }
        
        /* App Layout */
        .app-container {
            min-height: 100vh;
            background: #ffffff;
        }
        
        /* Header */
        .crypto-header {
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            padding: 1rem 0;
        }
        
        .crypto-header.transparent {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.25rem;
            max-width: 100%;
        }
        
        /* User Profile Section */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #960ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
        }
        
        .user-greeting {
            color: #64748b;
            font-size: 0.75rem;
            margin: 0;
            font-weight: 400;
        }
        
        .user-name {
            color: #0f172a;
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
        }
        
        /* Header Actions */
        .header-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .header-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f5f9;
            border: none;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            text-decoration: none;
            position: relative;
        }
        
        .header-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
            transform: scale(1.05);
            text-decoration: none;
        }
        
        .header-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: white;
            font-size: 0.625rem;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
            border: 2px solid #ffffff;
        }
        
        /* Back Header Variant */
        .header-back {
            display: flex;
            align-items: center;
            gap: 1rem;
            width: 100%;
        }
        
        .header-title {
            color: #260035;
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0;
            text-align: center !important;
            justify-content: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding-bottom: 2rem;
        }
        
        /* Mobile Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 0.5rem 0;
            z-index: 1000;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            text-decoration: none;
            color: #94a3b8;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            font-size: 0.75rem;
            font-weight: 500;
            position: relative;
            min-width: 60px;
        }
        
        .nav-item.active {
            color: #960ccc;
            background: #f3e8ff;
        }
        
        .nav-item:hover {
            color: #960ccc;
            text-decoration: none;
        }
        
        .nav-item i {
            font-size: 1.25rem;
            margin-bottom: 0.125rem;
        }
        
        .nav-item .nav-badge {
            position: absolute;
            top: 0.25rem;
            right: 0.5rem;
            background: #ef4444;
            color: white;
            font-size: 0.625rem;
            padding: 2px 5px;
            border-radius: 8px;
            min-width: 14px;
            text-align: center;
        }
        
        /* Flash Messages */
        .flash-messages {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 1055;
            max-width: 300px;
        }
        
        .flash-message {
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        
        /* Loading States */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(4px);
        }
        
        .loading-spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e2e8f0;
            border-top: 3px solid #960ccc;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Form Elements Override */
        .form-control {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #0f172a !important;
            border-radius: 0.5rem !important;
            font-family: 'Nunito Sans', system-ui, -apple-system, sans-serif !important;
        }
        
        .form-control:focus {
            background-color: #ffffff !important;
            border-color: #960ccc !important;
            color: #0f172a !important;
            box-shadow: 0 0 0 0.2rem rgba(150, 12, 204, 0.25) !important;
        }
        
        .form-select {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #0f172a !important;
        }
        
        /* Button Overrides */
        .btn-primary {
            background-color: #960ccc !important;
            border-color: #960ccc !important;
            color: white !important;
            border-radius: 0.5rem !important;
            font-weight: 500 !important;
        }
        
        .btn-primary:hover {
            background-color: #7c0ca3 !important;
            border-color: #7c0ca3 !important;
        }
        
        .btn-success {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }
        
        .btn-success:hover {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }
        
        .btn-danger {
            background-color: #ef4444 !important;
            border-color: #ef4444 !important;
        }
        
        .btn-danger:hover {
            background-color: #dc2626 !important;
            border-color: #dc2626 !important;
        }
        
        /* Card Overrides */
        .card {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1) !important;
            color: #0f172a !important;
        }
        
        .card-header {
            background-color: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            color: #0f172a !important;
        }
        
        /* Alert Overrides */
        .alert {
            border-radius: 0.5rem !important;
            border: none !important;
            font-weight: 500 !important;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #059669 !important;
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1) !important;
            color: #dc2626 !important;
        }
        
        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1) !important;
            color: #d97706 !important;
        }
        
        .alert-info {
            background-color: rgba(150, 12, 204, 0.1) !important;
            color: #960ccc !important;
        }
        
        /* Enhanced crypto card styling */
        .crypto-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .crypto-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .gradient-card {
            border: none;
            color: white;
            position: relative;
        }

        /* Market item enhancements */
        .market-item {
            transition: all 0.2s ease;
            border-radius: 12px;
            cursor: pointer;
        }

        .market-item:hover {
            background: #f8fafc;
            transform: translateX(4px);
        }

        /* Account card specific styling */
        .account-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .account-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Enhanced avatar styling */
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            overflow: hidden;
            flex-shrink: 0;
        }

        .avatar-30 { width: 30px; height: 30px; font-size: 0.75rem; }
        .avatar-40 { width: 40px; height: 40px; font-size: 0.875rem; }
        .avatar-50 { width: 50px; height: 50px; font-size: 1rem; }
        .avatar-60 { width: 60px; height: 60px; font-size: 1.1rem; }
        .avatar-80 { width: 80px; height: 80px; font-size: 1.5rem; }

        /* Horizontal scroll enhancements */
        .overflow-auto::-webkit-scrollbar {
            height: 4px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Enhanced button styling */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Scale animation improvements */
        .scale-on-tap {
            transition: transform 0.1s ease;
        }

        .scale-on-tap:active {
            transform: scale(0.96);
        }

        /* Badge enhancements */
        .badge {
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                padding: 0 1rem;
            }
            
            .crypto-card {
                border-radius: 12px;
            }
            
            .avatar-80 { 
                width: 60px; 
                height: 60px; 
                font-size: 1.25rem; 
            }
            
            .avatar-60 { 
                width: 50px; 
                height: 50px; 
                font-size: 1rem; 
            }
            
            h1 { 
                font-size: 2rem !important; 
            }
            
            h4 { 
                font-size: 1.25rem !important; 
            }
            
            .account-card {
                min-width: 260px !important;
            }
            
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-bottom-nav {
                display: none;
            }
            
            body {
                padding-bottom: 0;
            }
        }

        @media (max-width: 768px) {
            .overflow-auto {
                padding-bottom: 12px;
            }
            
            .crypto-card:hover {
                transform: none;
            }
            
            .account-card:hover {
                transform: translateY(-2px);
            }
        }
        
        /* Utilities */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .scale-on-tap {
            transition: transform 0.1s ease;
        }
        
        .scale-on-tap:active {
            transform: scale(0.98);
        }

        /* Icon styling */
        .heroicon {
            width: 1.25rem;
            height: 1.25rem;
        }

        .heroicon-sm {
            width: 1rem;
            height: 1rem;
        }

        .heroicon-lg {
            width: 1.5rem;
            height: 1.5rem;
        }

        /* Remix icon sizing */
        .ri-lg {
            font-size: 1.25rem;
        }

        .ri-xl {
            font-size: 1.5rem;
        }

        .ri-2x {
            font-size: 2rem;
        }

        /* Text utilities */
        .text-purple-primary { color: #960ccc; }
        .text-purple-dark { color: #7c0ca3; }
        .bg-purple-primary { background-color: #960ccc; }
        .bg-purple-light { background-color: #f3e8ff; }
        .border-purple-primary { border-color: #960ccc; }
    </style>
    
    @livewireStyles
    @stack('styles')
</head>

<body>
    <div id="" class="theme-orange">
        <div class="app-container">
            
            <!-- Header -->
            @if(!isset($headerType) || $headerType === 'default')
            <header class="crypto-header {{ $headerClass ?? '' }}">
                <div class="header-content">
                    <!-- User Profile -->
                    <div class="user-profile">
                        <div class="user-avatar">
                            @if(Auth::check() && Auth::user()->profile_photo_path)
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile">
                            @else
                                {{ Auth::check() ? strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) : 'GU' }}
                            @endif
                        </div>
                        <div class="user-info">
                            <p class="user-greeting">{{ $greeting ?? 'Welcome back,' }}</p>
                            <h5 class="user-name">{{ Auth::user()->name ?? 'Guest User' }}</h5>
                        </div>
                    </div>
                    
                    <!-- Header Actions -->
                    <div class="header-actions">
                        <a href="{{ route('user.search') ?? '#' }}" class="header-btn scale-on-tap">
                            <svg class="heroicon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </a>
                        <a href="{{ route('user.notifications') ?? '#' }}" class="header-btn scale-on-tap">
                            <svg class="heroicon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                                <span class="badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </header>
            @endif

            <!-- Back Header -->
            @if(isset($headerType) && $headerType === 'back')
            <header class="crypto-header">
                <div class="header-content">
                    <div class="header-back">
                        <button class="header-btn scale-on-tap" onclick="history.back()" wire:loading.attr="disabled">
                            <svg class="heroicon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                        </button>

                        <h6 class="header-title" style="text-align: center; width: 2000%;">
                            @yield('page-title', $pageTitle ?? 'CryptoWallet')
                        </h6>

                        @if(isset($rightAction))
                            {!! $rightAction !!}
                        @else
                            <div class="header-btn invisible">
                                <svg class="heroicon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </header>
            @endif

            <!-- Flash Messages -->
            <div class="flash-messages">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show flash-message" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        {{ session('success') }}
                        <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show flash-message" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        {{ session('error') }}
                        <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
                    </div>
                @endif

                @if(session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible fade show flash-message" role="alert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show flash-message" role="alert" x-data="{ show: true }" x-show="show">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" @click="show = false" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <!-- Mobile Bottom Navigation -->
            <nav class="mobile-bottom-nav d-md-none">
                <a href="{{ route('user.dashboard') ?? '#' }}" 
                   class="nav-item scale-on-tap {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i data-feather="home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('user.markets') ?? '#' }}" 
                   class="nav-item scale-on-tap {{ request()->routeIs('markets*') ? 'active' : '' }}">
                    <i data-feather="trending-up"></i>
                    <span>Markets</span>
                </a>
                <a href="{{ route('user.portfolio') ?? '#' }}" 
                   class="nav-item scale-on-tap {{ request()->routeIs('portfolio*') ? 'active' : '' }}">
                    <i data-feather="pie-chart"></i>
                    <span>Portfolio</span>
                </a>
                <a href="{{ route('user.notifications') ?? '#' }}" 
                   class="nav-item scale-on-tap {{ request()->routeIs('notifications*') ? 'active' : '' }}">
                    <i data-feather="bell"></i>
                    <span>Alerts</span>
                    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                        <span class="nav-badge">{{ Auth::user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
                <a href="{{ route('user.profile') ?? '#' }}" 
                   class="nav-item scale-on-tap {{ request()->routeIs('profile*') ? 'active' : '' }}">
                    <i data-feather="user"></i>
                    <span>Profile</span>
                </a>
            </nav>

            <!-- Loading Overlay -->
            <div wire:loading.flex class="loading-overlay">
                <div class="loading-spinner"></div>
            </div>
        </div>
    </div>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Feather Icons
            feather.replace();
            
            document.addEventListener('livewire:update', function () {
                setTimeout(() => feather.replace(), 10);
            });
            
            // Mobile touch feedback
            const touchElements = document.querySelectorAll('.scale-on-tap');
            touchElements.forEach(element => {
                element.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                });
                
                element.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
                
                element.addEventListener('touchcancel', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
            // Navigation active state management
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Add haptic feedback if supported
                    if (navigator.vibrate) {
                        navigator.vibrate(10);
                    }
                });
            });
            
            // Handle network status
            window.addEventListener('online', function() {
                console.log('Connection restored');
                // You can emit Livewire events here if needed
                // Livewire.emit('connectionRestored');
            });

            window.addEventListener('offline', function() {
                console.log('Connection lost');
                // Show offline notification
            });
            
            // Auto-refresh functionality (every 30 seconds)
            setInterval(() => {
                if (document.visibilityState === 'visible') {
                    // Emit Livewire refresh events for real-time data
                    // Livewire.emit('refreshData');
                }
            }, 30000);
        });

        // Global Livewire event listeners
        window.addEventListener('show-toast', event => {
            // Custom toast implementation
            console.log(`Toast: ${event.detail.type} - ${event.detail.message}`);
        });

        window.addEventListener('refresh-page', () => {
            location.reload();
        });

        window.addEventListener('redirect', event => {
            window.location.href = event.detail.url;
        });

        // PWA Install prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            deferredPrompt = e;
            // Show install button if needed
        });

        // Service Worker registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered: ', registration);
                    })
                    .catch(registrationError => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

     
    
    @livewireScripts

  
    
    @stack('scripts')
</body>
</html>