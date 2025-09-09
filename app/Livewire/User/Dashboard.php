<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\CoinPrice;
use App\Models\Trade;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
public $totalBalance;
    public $accounts = [];
    public $marketData = [];
    public $isLoading = false;
    public $referralCode;
    public $referralEarnings;
    public $recentTransactions = [];

    protected $listeners = [
        'refreshBalance' => 'loadAccountData',
        'accountUpdated' => 'loadAccountData',
        'loadMarketData' => 'loadMarketData'
    ];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function render()
    {
        return view('livewire.user.dashboard');
    }

    public function loadDashboardData()
    {
        $this->isLoading = true;
        
        try {
            $this->loadAccountData();
            $this->loadMarketData();
            $this->loadReferralData();
            $this->loadRecentTransactions();
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'message' => 'Error loading dashboard data. Please refresh.'
            ]);
        }
        
        $this->isLoading = false;
    }

    public function loadAccountData()
    {
        $user = Auth::user();
        
        // Get all user accounts
        $userAccounts = Account::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();
        
        // Calculate total balance (convert crypto to USD for total)
        $this->totalBalance = 0;
        
        // Format accounts for display
        $this->accounts = $userAccounts->map(function($account) {
            $usdValue = $this->convertToUSD($account->balance, $account->currency);
            $this->totalBalance += $usdValue;
            
            return [
                'id' => $account->id,
                'type' => $account->type,
                'currency' => $account->currency,
                'address' => $account->address,
                'balance' => $account->balance,
                'formatted_balance' => number_format($account->balance, $account->type === 'crypto' ? 8 : 2),
                'usd_value' => $usdValue,
                'formatted_usd_value' => number_format($usdValue, 2),
                'icon' => $this->getCurrencyIcon($account->currency),
                'color' => $this->getCurrencyColor($account->currency),
                'change_24h' => $this->getAccount24hChange($account->id),
                'is_primary' => $account->currency === 'USD' && $account->type === 'fiat'
            ];
        })->sortBy([
            ['is_primary', 'desc'],
            ['type', 'asc'],
            ['currency', 'asc']
        ]);
    }

    public function loadMarketData()
    {
        try {
            // Get current coin prices from database
            $coinPrices = CoinPrice::whereIn('symbol', ['BTC', 'ETH', 'BNB', 'ADA', 'USDT', 'LTC', 'DOGE', 'XRP', 'TRX', 'BCH'])
                ->latest('updated_at')
                ->get()
                ->keyBy('symbol');

            $this->marketData = [
                [
                    'symbol' => 'BTC',
                    'name' => 'Bitcoin',
                    'price' => $coinPrices->get('BTC')->price_usd ?? 43250.50,
                    'change_24h' => $this->calculatePriceChange('BTC'),
                    'volume' => '1.2B',
                    'chart_data' => $this->getHistoricalPriceData('BTC', 30)
                ],
                [
                    'symbol' => 'ETH', 
                    'name' => 'Ethereum',
                    'price' => $coinPrices->get('ETH')->price_usd ?? 2650.75,
                    'change_24h' => $this->calculatePriceChange('ETH'),
                    'volume' => '890M',
                    'chart_data' => $this->getHistoricalPriceData('ETH', 30)
                ],
                [
                    'symbol' => 'BNB',
                    'name' => 'BNB',
                    'price' => $coinPrices->get('BNB')->price_usd ?? 315.20,
                    'change_24h' => $this->calculatePriceChange('BNB'),
                    'volume' => '245M',
                    'chart_data' => $this->getHistoricalPriceData('BNB', 30)
                ],
                [
                    'symbol' => 'ADA',
                    'name' => 'Cardano', 
                    'price' => $coinPrices->get('ADA')->price_usd ?? 0.485,
                    'change_24h' => $this->calculatePriceChange('ADA'),
                    'volume' => '158M',
                    'chart_data' => $this->getHistoricalPriceData('ADA', 30)
                ]
            ];
        } catch (\Exception $e) {
            // Fallback to mock data if DB is empty
            $this->marketData = [
                ['symbol' => 'BTC', 'name' => 'Bitcoin', 'price' => 43250.50, 'change_24h' => 2.45, 'volume' => '1.2B', 'chart_data' => $this->generateChartData(30)],
                ['symbol' => 'ETH', 'name' => 'Ethereum', 'price' => 2650.75, 'change_24h' => -1.23, 'volume' => '890M', 'chart_data' => $this->generateChartData(30)],
                ['symbol' => 'BNB', 'name' => 'BNB', 'price' => 315.20, 'change_24h' => 0.85, 'volume' => '245M', 'chart_data' => $this->generateChartData(30)],
                ['symbol' => 'ADA', 'name' => 'Cardano', 'price' => 0.485, 'change_24h' => 3.12, 'volume' => '158M', 'chart_data' => $this->generateChartData(30)]
            ];
        }
        
        $this->dispatch('market-data-updated');
    }

    public function loadRecentTransactions()
    {
        $user = Auth::user();
        
        $this->recentTransactions = Transaction::where('user_id', $user->id)
            ->with('account')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function($transaction) {
                return [
                    'id' => $transaction->id,
                    'type' => $transaction->type,
                    'method' => $transaction->method,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency,
                    'status' => $transaction->status,
                    'reference' => $transaction->reference,
                    'created_at' => $transaction->created_at->format('M d, g:i A'),
                    'icon' => $this->getTransactionIcon($transaction->type),
                    'color' => $this->getTransactionColor($transaction->type, $transaction->status)
                ];
            });
    }

    public function loadReferralData()
    {
        $user = Auth::user();
        $this->referralCode = $user->referral_code ?? $this->generateReferralCode();
        $this->referralEarnings = $user->referral_earnings ?? 0;
    }

    // New helper methods for enhanced dashboard
    public function getPortfolio24hChange()
    {
        $yesterday = Carbon::yesterday();
        $yesterdayBalance = $this->getTotalBalanceForDate($yesterday);
        
        $change = $this->totalBalance - $yesterdayBalance;
        $changePercent = $yesterdayBalance > 0 ? (($change / $yesterdayBalance) * 100) : 0;
        
        return [
            'amount' => $change,
            'percent' => $changePercent
        ];
    }

    public function getDailyStats()
    {
        $portfolioChange = $this->getPortfolio24hChange();
        return [
            'amount' => $portfolioChange['amount'],
            'percent' => $portfolioChange['percent']
        ];
    }

    public function getMonthlyEarnings()
    {
        return Auth::user()->transactions()
            ->where('type', 'credit')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount') ?? 456.50;
    }

    public function getPortfolioBreakdown()
    {
        $breakdown = [];
        $total = $this->totalBalance;
        
        if ($total <= 0) {
            return [
                ['currency' => 'USD', 'percentage' => 100, 'color' => '#10B981']
            ];
        }
        
        foreach ($this->accounts as $account) {
            $percentage = ($account['usd_value'] / $total) * 100;
            if ($percentage > 0) {
                $breakdown[] = [
                    'currency' => $account['currency'],
                    'percentage' => round($percentage, 1),
                    'color' => $account['color']
                ];
            }
        }
        
        return $breakdown;
    }

    private function getTotalBalanceForDate($date)
    {
        // This should query historical balance data
        // For now, simulate with a small random variation
        return $this->totalBalance * (0.95 + (mt_rand(0, 100) / 1000));
    }

    private function convertToUSD($amount, $currency)
    {
        if ($currency === 'USD') {
            return (float) $amount;
        }

        // Get current price from coin_prices table
        $coinPrice = CoinPrice::where('symbol', $currency)->latest()->first();
        
        if ($coinPrice) {
            return (float) $amount * $coinPrice->price_usd;
        }

        // Fallback prices if not in database
        $fallbackPrices = [
            'BTC' => 43250,
            'ETH' => 2650,
            'BNB' => 315,
            'USDT' => 1,
            'ADA' => 0.48,
            'LTC' => 92,
            'DOGE' => 0.085,
            'XRP' => 0.52,
            'TRX' => 0.095,
            'BCH' => 245
        ];

        $rate = $fallbackPrices[$currency] ?? 1;
        return (float) $amount * $rate;
    }

    private function calculatePriceChange($symbol)
    {
        $current = CoinPrice::where('symbol', $symbol)->latest()->first();
        $yesterday = CoinPrice::where('symbol', $symbol)
            ->where('created_at', '<=', now()->subDay())
            ->latest()
            ->first();

        if ($current && $yesterday && $yesterday->price_usd > 0) {
            return (($current->price_usd - $yesterday->price_usd) / $yesterday->price_usd) * 100;
        }

        // Return random change for demo
        return mt_rand(-500, 500) / 100;
    }

    private function getHistoricalPriceData($symbol, $days)
    {
        $prices = CoinPrice::where('symbol', $symbol)
            ->where('created_at', '>=', now()->subDays($days))
            ->orderBy('created_at')
            ->pluck('price_usd')
            ->toArray();

        if (count($prices) < $days / 2) {
            return $this->generateChartData($days);
        }

        return $prices;
    }

    private function getAccount24hChange($accountId)
    {
        $yesterday = now()->subDay();
        $transactions = Transaction::where('account_id', $accountId)
            ->where('created_at', '>=', $yesterday)
            ->where('status', 'completed')
            ->sum(DB::raw('CASE WHEN type = "credit" THEN amount ELSE -amount END'));
            
        return (float) $transactions;
    }

    private function generateChartData($points)
    {
        $data = [];
        $basePrice = 100 + mt_rand(0, 200);
        
        for ($i = 0; $i < $points; $i++) {
            $variation = mt_rand(-5, 5);
            $basePrice = max($basePrice + $variation, 50);
            $data[] = round($basePrice, 2);
        }
        
        return $data;
    }

    private function getCurrencyIcon($currency)
    {
        return match(strtoupper($currency)) {
            'USD' => 'bi-currency-dollar',
            'BTC' => 'bi-currency-bitcoin',
            'ETH' => 'bi-currency-exchange',
            'BNB' => 'bi-coin',
            'USDT' => 'bi-currency-dollar',
            'ADA' => 'bi-heart',
            'LTC' => 'bi-circle',
            'DOGE' => 'bi-heart-fill',
            'XRP' => 'bi-water',
            'TRX' => 'bi-triangle',
            'BCH' => 'bi-currency-bitcoin',
            'EUR' => 'bi-currency-euro',
            'GBP' => 'bi-currency-pound',
            default => 'bi-wallet'
        };
    }

    private function getCurrencyColor($currency)
    {
        return match(strtoupper($currency)) {
            'USD' => '#28a745',
            'BTC' => '#f7931a',
            'ETH' => '#627eea',
            'BNB' => '#f0b90b',
            'USDT' => '#26a17b',
            'ADA' => '#0033ad',
            'LTC' => '#bfbbbb',
            'DOGE' => '#c2a633',
            'XRP' => '#23292f',
            'TRX' => '#ff060a',
            'BCH' => '#0ac18e',
            'EUR' => '#0d6efd',
            'GBP' => '#6f42c1',
            default => '#6c757d'
        };
    }

    private function getTransactionIcon($type)
    {
        return match($type) {
            'credit' => 'bi-arrow-down-circle',
            'debit' => 'bi-arrow-up-circle',
            'transfer' => 'bi-arrow-left-right',
            'deposit' => 'bi-plus-circle',
            'withdrawal' => 'bi-dash-circle',
            'buy' => 'bi-cart-plus',
            'sell' => 'bi-cart-dash',
            default => 'bi-circle'
        };
    }

    private function getTransactionColor($type, $status)
    {
        if ($status !== 'completed') {
            return 'warning';
        }

        return match($type) {
            'credit', 'deposit' => 'success',
            'debit', 'withdrawal' => 'danger',
            'transfer' => 'info',
            'buy' => 'primary',
            'sell' => 'secondary',
            default => 'secondary'
        };
    }

    private function generateReferralCode()
    {
        return 'REF' . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    // Action Methods
    public function deposit()
    {
        return redirect()->route('user.wallets');
    }

    public function withdraw()
    {
        return redirect()->route('user.dashboard');
    }

    public function viewAllAccounts()
    {
        return redirect()->route('user.wallets');
    }

    public function createAccount()
    {
        return "Account creation page not implemented yet.";
    }

    public function goToTradingPage()
    {
        return "Trading page redirection not implemented yet.";
    }

    public function quickBuy()
    {
        $this->dispatch('show-quick-buy-modal');
    }

    public function quickSell()
    {
        $this->dispatch('show-quick-sell-modal');
    }

    public function quickSwap()
    {
        $this->dispatch('show-quick-swap-modal');
    }

    public function quickSend()
    {
        $this->dispatch('show-quick-send-modal');
    }

    public function copyReferralCode()
    {
        $this->dispatch('copy-to-clipboard', $this->referralCode);
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Referral code copied to clipboard!'
        ]);
    }

    public function shareReferral($platform)
    {
        $referralUrl = route('register', ['ref' => $this->referralCode]);
        $message = "Join me on " . config('app.name') . " and start investing! Use my referral code: {$this->referralCode}";
        
        $shareUrls = [
            'whatsapp' => "https://wa.me/?text=" . urlencode($message . " " . $referralUrl),
            'telegram' => "https://t.me/share/url?url=" . urlencode($referralUrl) . "&text=" . urlencode($message),
            'twitter' => "https://twitter.com/intent/tweet?text=" . urlencode($message) . "&url=" . urlencode($referralUrl),
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($referralUrl)
        ];

        if (isset($shareUrls[$platform])) {
            $this->dispatch('open-url', $shareUrls[$platform]);
        }
    }

    public function viewAllTransactions()
    {
        return redirect()->route('user.transactions');
    }

    public function refreshDashboard()
    {
        $this->loadDashboardData();
        $this->dispatch('show-toast', [
            'type' => 'success',
            'message' => 'Dashboard refreshed successfully!'
        ]);
    }
    
}



