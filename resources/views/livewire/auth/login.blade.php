<div>
    <div class="container">
        <div class="card border" style="border-radius: 1px;">
            <div class="card-body p-5">
                <!-- Logo Section -->
                <div class="text-center mb-4">
                    <div class="brand-logo">
                        <div class="logo-icon">
                            <i class="bi bi-graph-up text-white"></i>
                        </div>
                        <div>
                            <div class="logo-text">FX Online Pro</div>
                        </div>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 0.9rem;">Access your trading account</p>
                </div>

                <!-- Alerts -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border: none;">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border: none;">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form wire:submit.prevent="authenticate">
                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium text-dark">Email Address</label>
                        <input 
                            type="email" 
                            id="email"
                            class="form-control @error('email') is-invalid @enderror" 
                            wire:model.defer="email"
                            placeholder="Enter your email address"
                            autocomplete="email"
                            style="border-radius: 10px; padding: 12px 16px; border: 1px solid #d1d5db; font-size: 0.9rem;"
                        >
                        @error('email')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" class="form-label fw-medium text-dark">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none text-primary-custom" style="font-size: 0.85rem; font-weight: 500;">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>
                        <input 
                            type="password" 
                            id="password"
                            class="form-control @error('password') is-invalid @enderror" 
                            wire:model.defer="password"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            style="border-radius: 10px; padding: 12px 16px; border: 1px solid #d1d5db; font-size: 0.9rem;"
                        >
                        @error('password')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                id="remember" 
                                class="form-check-input"
                                wire:model.defer="remember"
                                style="border-color: var(--primary-color);"
                            >
                            <label class="form-check-label text-muted" for="remember" style="font-size: 0.9rem;">
                                Remember me for 30 days
                            </label>
                        </div>
                    </div>

                    <!-- Sign In Button -->
                    <button type="submit" class="btn w-100 text-white fw-semibold" wire:loading.attr="disabled" style="background: var(--primary-color); border: none; border-radius: 10px; padding: 12px; font-size: 0.9rem; transition: all 0.2s ease;">
                        <span wire:loading.remove>
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>Signing in...
                        </span>
                    </button>
                </form>

                <!-- Social Login -->
                <div class="divider my-4">
                    <span class="px-3 text-muted bg-white" style="font-size: 0.85rem;">or continue with</span>
                </div>

                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <button type="button" class="btn w-100 d-flex align-items-center justify-content-center" style="background: #1877f2; color: white; border: none; border-radius: 8px; padding: 10px; font-size: 0.85rem; font-weight: 500;">
                            <i class="bi bi-facebook me-2"></i>
                            <span>Facebook</span>
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn w-100 d-flex align-items-center justify-content-center" style="background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px; font-size: 0.85rem; font-weight: 500;">
                            <i class="bi bi-google me-2"></i>
                            <span>Google</span>
                        </button>
                    </div>
                </div>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="text-center pt-3" style="border-top: 1px solid #e5e7eb;">
                        <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-decoration-none text-primary-custom fw-semibold">Create one</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>