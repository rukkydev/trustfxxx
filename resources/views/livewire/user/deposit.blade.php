<div>

    <div class="container-fluid p-0">
        <!-- Loading Overlay -->
        <div wire:loading.flex class="loading-overlay">
            <div class="loading-spinner"></div>
        </div>

        <!-- Deposit Form Section -->
        <div class="px-3 mb-4">
            <div class="card crypto-card">
                <div class="card-body p-4">
                    <h6 class="mb-4 fw-semibold">Deposit Amount</h6>

                    <!-- Amount Input -->
                    <div class="mb-4">
                        <div class="amount-input-container">
                            <span class="currency-symbol">$</span>
                            <input type="number" class="form-control amount-input" placeholder="0.00"
                                wire:model="amount" step="0.01" min="10" required>
                        </div>

                        @error('amount')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror

                        <!-- Quick Amount Buttons -->
                        <div class="d-flex gap-2 mt-3 flex-wrap">
                            <button type="button" class="quick-amount-btn scale-on-tap" wire:click="setAmount(50)"
                                :class="{ 'active': amount == 50 }">
                                $50
                            </button>
                            <button type="button" class="quick-amount-btn scale-on-tap" wire:click="setAmount(100)"
                                :class="{ 'active': amount == 100 }">
                                $100
                            </button>
                            <button type="button" class="quick-amount-btn scale-on-tap" wire:click="setAmount(250)"
                                :class="{ 'active': amount == 250 }">
                                $250
                            </button>
                            <button type="button" class="quick-amount-btn scale-on-tap" wire:click="setAmount(500)"
                                :class="{ 'active': amount == 500 }">
                                $500
                            </button>
                            <button type="button" class="quick-amount-btn scale-on-tap" wire:click="setAmount(1000)"
                                :class="{ 'active': amount == 1000 }">
                                $1000
                            </button>
                        </div>
                    </div>

                    <h6 class="mb-3 fw-semibold">Payment Method</h6>

                    <!-- Payment Methods - Radio Group -->
                    <div class="mb-4">
                        @if($paymentMethods && count($paymentMethods) > 0)
                        <div class="row g-3">
                            @foreach($paymentMethods as $method)
                            <div class="col-12">
                                <label
                                    class="payment-method-card scale-on-tap {{ $selectedMethod == $method['id'] ? 'selected' : '' }}">
                                    <input type="radio" name="payment_method" value="{{ $method['id'] }}"
                                        wire:model="selectedMethod" class="d-none">
                                    <div class="payment-method-content">
                                        <div class="payment-method-icon">
                                            <i data-feather="{{ $method['icon'] }}"></i>
                                        </div>
                                        <div class="payment-method-details">
                                            <div class="payment-method-title">{{ $method['name'] }}</div>
                                            <p class="payment-method-description">{{ $method['details'] }}</p>
                                        </div>
                                        @if($selectedMethod == $method['id'])
                                        <div class="text-primary">
                                            <i data-feather="check-circle"></i>
                                        </div>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        @error('selectedMethod')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        @else
                        <div class="text-center py-4">
                            <div class="avatar avatar-80 bg-light rounded-circle mx-auto mb-3">
                                <i data-feather="credit-card" class="text-muted h2 mb-0"></i>
                            </div>
                            <h6 class="text-muted mb-2 fw-semibold">No Payment Methods</h6>
                            <p class="text-muted small mb-4">Please add a payment method to continue</p>
                            <button class="btn btn-primary scale-on-tap" wire:click="addPaymentMethod">
                                <i data-feather="plus-circle" class="me-2"></i> Add Payment Method
                            </button>
                        </div>
                        @endif
                    </div>

                    <!-- Security Badge -->
                    <div class="d-flex justify-content-center mb-4">
                        <div class="security-badge">
                            <i data-feather="shield" style="width: 16px; height: 16px;"></i>
                            <span>Secure & Encrypted Transaction</span>
                        </div>
                    </div>

                    <!-- Continue Button -->
                    <button class="btn btn-primary w-100 scale-on-tap py-3 fw-semibold" wire:click="processDeposit"
                        wire:loading.attr="disabled" {{ !$selectedMethod || !$amount ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="processDeposit">
                            Continue to Deposit
                        </span>
                        <span wire:loading wire:target="processDeposit">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Processing...
                        </span>
                    </button>

                    <!-- Terms Notice -->
                    <p class="text-center text-muted small mt-3">
                        By continuing, you agree to our <a href="#" class="text-primary">Terms of Service</a>
                        and <a href="#" class="text-primary">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Recent Deposits -->
        <div class="px-3 mb-4">
            <div class="card crypto-card">
                <div class="card-header border-0  p-4 pb-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-semibold">Recent Deposits</h6>
                        <button class="btn btn-sm btn-outline-primary scale-on-tap" wire:click="viewAllTransactions">
                            View All <i data-feather="arrow-right" class="ms-1"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if(count($recentDeposits) > 0)
                    @foreach($recentDeposits as $deposit)
                    <div class="d-flex align-items-center py-3 {{ !$loop->last ? 'border-bottom border-light' : '' }}">
                        <div class="avatar avatar-40 rounded-circle me-3 bg-success">
                            <i data-feather="arrow-down-circle" class="text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-semibold">Deposit</h6>
                            <p class="small text-muted mb-0">
                                {{ $deposit['created_at']->format('M d, Y') }}
                                @if($deposit['reference'])
                                • {{ $deposit['reference'] }}
                                @endif
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0 fw-bold text-success">+${{ number_format($deposit['amount'], 2) }}</h6>
                            <small class="badge text-bg-{{ $deposit['status_color'] }}">
                                {{ ucfirst($deposit['status']) }}
                            </small>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="text-center py-4">
                        <div class="avatar avatar-80 bg-light rounded-circle mx-auto mb-3">
                            <i data-feather="arrow-down-circle" class="text-muted h2 mb-0"></i>
                        </div>
                        <h6 class="text-muted mb-2 fw-semibold">No Recent Deposits</h6>
                        <p class="text-muted small">Your deposit history will appear here</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

   

</div>