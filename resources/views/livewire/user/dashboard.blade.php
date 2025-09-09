<div>
<div class="mobile-dashboard">
    <!-- Loading Overlay -->
    <div wire:loading.class.remove="d-none" class="d-none loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Balance Section -->
    <div class="balance-section">
        <div class="balance-card">
            <div class="balance-content">
                <div class="balance-header">
                    <div class="balance-info">
                        <span class="balance-label">Total Balance</span>
                        <h1 class="balance-amount">${{ number_format($totalBalance, 2) }}</h1>
                        <div class="balance-change positive">
                            <i class="bi bi-trending-up"></i>
                            <span>+2.45% today</span>
                        </div>
                    </div>
                    <div class="balance-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button class="action-btn primary" wire:click="deposit" wire:loading.attr="disabled">
                        <i class="bi bi-plus-lg"></i>
                        <span>Deposit</span>
                    </button>
                    <button class="action-btn secondary" wire:click="withdraw" wire:loading.attr="disabled">
                        <i class="bi bi-arrow-up"></i>
                        <span>Withdraw</span>
                    </button>
                    <button class="action-btn tertiary" wire:click="trade">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Trade</span>
                    </button>
                    <button class="action-btn quaternary" wire:click="more">
                        <i class="bi bi-three-dots"></i>
                        <span>More</span>
                    </button>
                </div>
            </div>
            
            <!-- Background decoration -->
            <div class="balance-bg-decoration"></div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-section">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon success">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">+12.5%</span>
                    <span class="stat-label">24h Change</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon info">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">$8,250</span>
                    <span class="stat-label">Today's P&L</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Market Data -->
    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Live Markets</h3>
            <button class="refresh-btn" wire:click="loadMarketData" wire:loading.attr="disabled">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
        
        <div class="market-grid">
            @foreach($marketData as $index => $market)
            <div class="market-card">
                <div class="market-header">
                    <div class="crypto-icon {{ strtolower($market['symbol']) }}">
                        {{ substr($market['symbol'], 0, 1) }}
                    </div>
                    <div class="market-info">
                        <span class="crypto-name">{{ $market['symbol'] }}</span>
                        <span class="crypto-fullname">{{ $market['name'] }}</span>
                    </div>
                </div>
                <div class="market-data">
                    <span class="crypto-price">${{ number_format($market['price'], $market['price'] < 1 ? 4 : 2) }}</span>
                    <span class="crypto-change {{ $market['change_24h'] >= 0 ? 'positive' : 'negative' }}">
                        <i class="bi bi-caret-{{ $market['change_24h'] >= 0 ? 'up' : 'down' }}-fill"></i>
                        {{ number_format(abs($market['change_24h']), 2) }}%
                    </span>
                </div>
                <!-- Mini Chart -->
                <div class="mini-chart">
                    <canvas id="chart{{ $index }}" 
                            wire:ignore 
                            data-chart="{{ json_encode($market['chart_data']) }}"
                            data-color="{{ $market['change_24h'] >= 0 ? '#10B981' : '#EF4444' }}">
                    </canvas>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- My Wallets -->
    <div class="section">
        <div class="section-header">
            <h3 class="section-title">My Wallets</h3>
            <button class="view-all-btn" wire:click="viewAllAccounts">
                <span>View All</span>
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
        
        <div class="wallets-container">
            @if(count($accounts) > 0)
            <div class="wallets-scroll">
                @foreach($accounts as $account)
                <div class="wallet-card {{ $account['type'] }}">
                    <div class="wallet-header">
                        <div class="wallet-icon" style="background: {{ $account['color'] }}20;">
                            <i class="bi {{ $account['icon'] }}" style="color: {{ $account['color'] }};"></i>
                        </div>
                        <div class="wallet-badges">
                            <span class="wallet-type {{ $account['type'] }}">{{ ucfirst($account['type']) }}</span>
                            @if($account['is_primary'])
                            <span class="primary-badge">Primary</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="wallet-content">
                        <h4 class="wallet-currency">{{ $account['currency'] }}</h4>
                        <div class="wallet-balance">
                            <span class="balance-crypto">{{ $account['formatted_balance'] }} {{ $account['currency'] }}</span>
                            <span class="balance-usd">${{ $account['formatted_usd_value'] }} USD</span>
                        </div>
                        
                        <div class="wallet-change {{ $account['change_24h'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="bi bi-caret-{{ $account['change_24h'] >= 0 ? 'up' : 'down' }}-fill"></i>
                            <span>{{ $account['currency'] === 'USD' ? '$' : '' }}{{ number_format(abs($account['change_24h']), $account['type'] === 'crypto' ? 8 : 2) }}</span>
                            <span class="change-period">24h</span>
                        </div>
                        
                        @if($account['type'] === 'crypto' && $account['address'])
                        <div class="wallet-address">
                            {{ strlen($account['address']) > 20 ? substr($account['address'], 0, 10) . '...' . substr($account['address'], -6) : $account['address'] }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                
                <!-- Add New Wallet -->
                <div class="wallet-card add-wallet" wire:click="createAccount">
                    <div class="add-wallet-content">
                        <div class="add-icon">
                            <i class="bi bi-plus-lg"></i>
                        </div>
                        <span class="add-text">Add Wallet</span>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h4>No Wallets Yet</h4>
                <p>Create your first wallet to start managing your crypto assets</p>
                <button class="create-wallet-btn" wire:click="createAccount">
                    <i class="bi bi-plus-lg"></i>
                    Create Wallet
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="section">
        <div class="section-header">
            <h3 class="section-title">Recent Activity</h3>
            <a href="{{ route('user.transactions') }}" class="view-all-btn">
                <span>View All</span>
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
        
        <div class="activity-list">
            @if(count($recentTransactions) > 0)
                @foreach($recentTransactions as $transaction)
                <div class="activity-item">
                    <div class="activity-icon {{ $transaction['type'] }}">
                        <i class="bi {{ $transaction['icon'] }}"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-main">
                            <span class="activity-title">{{ ucfirst($transaction['type']) }}</span>
                            @if($transaction['method'])
                            <span class="activity-method">via {{ ucfirst($transaction['method']) }}</span>
                            @endif
                        </div>
                        <div class="activity-details">
                            <span class="activity-time">{{ $transaction['created_at'] }}</span>
                            @if($transaction['reference'])
                            <span class="activity-ref">{{ $transaction['reference'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="activity-amount">
                        <span class="amount {{ $transaction['type'] === 'credit' ? 'positive' : 'negative' }}">
                            {{ $transaction['type'] === 'credit' ? '+' : '-' }}{{ number_format($transaction['amount'], 2) }} {{ $transaction['currency'] }}
                        </span>
                        <span class="status {{ $transaction['status'] }}">{{ ucfirst($transaction['status']) }}</span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state small">
                    <div class="empty-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h4>No Recent Activity</h4>
                    <p>Your transaction history will appear here</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Mobile Dashboard Styles */
.mobile-dashboard {
    padding: 0;
    background: var(--background);
    min-height: calc(100vh - 140px);
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    backdrop-filter: blur(4px);
}

.loading-spinner {
    width: 32px;
    height: 32px;
    border: 3px solid var(--border);
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Balance Section */
.balance-section {
    padding: 0 20px 24px;
}

.balance-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    color: white;
    border: none;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
}

.balance-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 32px;
}

.balance-label {
    font-size: 14px;
    opacity: 0.8;
    font-weight: 400;
}

.balance-amount {
    font-size: 32px;
    font-weight: 700;
    margin: 8px 0;
    line-height: 1;
}

.balance-change {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 14px;
    font-weight: 500;
}

.balance-change.positive {
    color: #10B981;
}

.balance-change.negative {
    color: #EF4444;
}

.balance-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.balance-bg-decoration {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.balance-content {
    position: relative;
    z-index: 2;
}

/* Action Buttons */
.action-buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}

.action-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 16px;
    padding: 16px 8px;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    backdrop-filter: blur(10px);
    font-size: 12px;
    font-weight: 500;
}

.action-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.action-btn i {
    font-size: 20px;
}

/* Stats Section */
.stats-section {
    padding: 0 20px 24px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.stat-item {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-sm);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.stat-icon.info {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
}

.stat-content {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-label {
    font-size: 13px;
    color: var(--text-tertiary);
    margin-top: 4px;
}

/* Section Styles */
.section {
    padding: 0 20px 32px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.refresh-btn,
.view-all-btn {
    background: none;
    border: none;
    color: var(--primary);
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 8px 0;
    transition: all 0.2s ease;
}

.refresh-btn:hover,
.view-all-btn:hover {
    opacity: 0.8;
}

/* Market Grid */
.market-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

.market-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-sm);
}

.market-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.market-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.crypto-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
}

.crypto-icon.btc {
    background: linear-gradient(135deg, #F7931A, #FFA726);
}

.crypto-icon.eth {
    background: linear-gradient(135deg, #627EEA, #8E9AFF);
}

.crypto-icon.usdt {
    background: linear-gradient(135deg, #26A17B, #4CAF50);
}

.crypto-icon.bnb {
    background: linear-gradient(135deg, #F3BA2F, #FCD535);
}

.market-info {
    display: flex;
    flex-direction: column;
}

.crypto-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
}

.crypto-fullname {
    font-size: 12px;
    color: var(--text-tertiary);
}

.market-data {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.crypto-price {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
}

.crypto-change {
    display: flex;
    align-items: center;
    gap: 2px;
    font-size: 12px;
    font-weight: 600;
}

.crypto-change.positive {
    color: var(--success);
}

.crypto-change.negative {
    color: var(--danger);
}

.mini-chart {
    height: 40px;
}

.mini-chart canvas {
    width: 100% !important;
    height: 100% !important;
}

/* Wallets Container */
.wallets-container {
    margin: 0 -20px;
}

.wallets-scroll {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding: 0 20px;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.wallets-scroll::-webkit-scrollbar {
    display: none;
}

.wallet-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 20px;
    min-width: 280px;
    flex-shrink: 0;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-sm);
    border-left: 4px solid transparent;
}

.wallet-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.wallet-card.fiat {
    border-left-color: var(--success);
}

.wallet-card.crypto {
    border-left-color: var(--info);
}

.wallet-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.wallet-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.wallet-badges {
    display: flex;
    flex-direction: column;
    gap: 4px;
    align-items: flex-end;
}

.wallet-type,
.primary-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
}

.wallet-type.fiat {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.wallet-type.crypto {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
}

.primary-badge {
    background: rgba(79, 70, 229, 0.1);
    color: var(--primary);
}

.wallet-currency {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 12px 0;
}

.wallet-balance {
    margin-bottom: 12px;
}

.balance-crypto {
    display: block;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
}

.balance-usd {
    display: block;
    font-size: 13px;
    color: var(--text-tertiary);
    margin-top: 4px;
}

.wallet-change {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-bottom: 12px;
}

.wallet-change.positive {
    color: var(--success);
}

.wallet-change.negative {
    color: var(--danger);
}

.wallet-change span:first-of-type {
    font-size: 13px;
    font-weight: 600;
}

.change-period {
    font-size: 12px;
    opacity: 0.7;
}

.wallet-address {
    font-size: 11px;
    color: var(--text-muted);
    font-family: 'Courier New', monospace;
    padding: 8px 12px;
    background: var(--surface-secondary);
    border-radius: 8px;
    margin-top: 12px;
}

/* Add Wallet Card */
.add-wallet {
    border: 2px dashed var(--border) !important;
    background: var(--surface-secondary) !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.add-wallet:hover {
    border-color: var(--primary) !important;
    background: rgba(79, 70, 229, 0.05) !important;
}

.add-wallet-content {
    text-align: center;
}

.add-icon {
    width: 48px;
    height: 48px;
    background: rgba(79, 70, 229, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: var(--primary);
    margin: 0 auto 12px;
}

.add-text {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
}

/* Activity List */
.activity-list {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-light);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.activity-icon.credit {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.activity-icon.debit {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-main {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.activity-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
}

.activity-method {
    font-size: 12px;
    color: var(--text-tertiary);
}

.activity-details {
    display: flex;
    align-items: center;
    gap: 8px;
}

.activity-time,
.activity-ref {
    font-size: 12px;
    color: var(--text-muted);
}

.activity-amount {
    text-align: right;
    flex-shrink: 0;
}

.amount {
    display: block;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 4px;
}

.amount.positive {
    color: var(--success);
}

.amount.negative {
    color: var(--danger);
}

.status {
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 6px;
    text-transform: uppercase;
}

.status.completed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.status.pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.status.failed {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 48px 20px;
}

.empty-state.small {
    padding: 32px 20px;
}

.empty-icon {
    width: 64px;
    height: 64px;
    background: var(--surface-secondary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: var(--text-muted);
    margin: 0 auto 16px;
}

.empty-state h4 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-tertiary);
    margin: 0 0 24px 0;
}

.create-wallet-btn {
    background: var(--primary);
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    color: white;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 auto;
    transition: all 0.2s ease;
}

.create-wallet-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

/* Responsive */
@media (max-width: 768px) {
    .balance-amount {
        font-size: 28px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .market-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize mini charts
    @foreach($marketData as $index => $market)
    const ctx{{ $index }} = document.getElementById('chart{{ $index }}');
    if (ctx{{ $index }}) {
        const chartData = JSON.parse(ctx{{ $index }}.dataset.chart);
        const color = ctx{{ $index }}.dataset.color;
        
        new Chart(ctx{{ $index }}, {
            type: 'line',
            data: {
                labels: Array(chartData.length).fill(''),
                datasets: [{
                    data: chartData,
                    borderColor: color,
                    backgroundColor: color + '20',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                },
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: {
                    point: { radius: 0 }
                }
            }
        });
    }
    @endforeach
    
    // Touch interactions for mobile
    const touchElements = document.querySelectorAll('.action-btn, .wallet-card, .market-card, .activity-item');
    touchElements.forEach(element => {
        element.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        }, { passive: true });
        
        element.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        }, { passive: true });
    });
    
    // Auto-refresh market data
    setInterval(() => {
        if (typeof Livewire !== 'undefined' && document.visibilityState === 'visible') {
            Livewire.emit('loadMarketData');
        }
    }, 30000);
});

// Livewire event listeners
window.addEventListener('copy-to-clipboard', function(event) {
    const text = event.detail;
    navigator.clipboard.writeText(text).then(function() {
        console.log('Copied to clipboard:', text);
    });
});

window.addEventListener('open-url', function(event) {
    window.open(event.detail, '_blank');
});
</script>
@endpush
</div>

