<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'currency',
        'address',
        'balance',
        'status'
    ];

    protected $casts = [
        'balance' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope for crypto accounts only
    public function scopeCrypto($query)
    {
        return $query->where('type', 'crypto');
    }

    // Scope for fiat accounts only
    public function scopeFiat($query)
    {
        return $query->where('type', 'fiat');
    }

    // Scope for active accounts
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Get formatted balance
    public function getFormattedBalanceAttribute()
    {
        return number_format($this->balance, 8);
    }

    // Get crypto icon class
    public function getCryptoIconAttribute()
    {
        $icons = [
            'BTC' => 'fab fa-bitcoin',
            'ETH' => 'fab fa-ethereum',
            'USDT' => 'fas fa-dollar-sign',
            'BNB' => 'fas fa-coins',
            'LTC' => 'fab fa-btc', // Litecoin uses BTC icon variant
            'DOGE' => 'fas fa-dog',
            'XRP' => 'fas fa-water',
            'TRX' => 'fas fa-bolt',
            'BCH' => 'fab fa-bitcoin'
        ];

        return $icons[$this->currency] ?? 'fas fa-coins';
    }

    // Get crypto color theme
    public function getCryptoColorAttribute()
    {
        $colors = [
            'BTC' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
            'ETH' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
            'USDT' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
            'BNB' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
            'LTC' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
            'DOGE' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
            'XRP' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
            'TRX' => ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
            'BCH' => ['bg' => 'bg-green-100', 'text' => 'text-green-600']
        ];

        return $colors[$this->currency] ?? ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'];
    }

    // Get crypto full name
    public function getCryptoNameAttribute()
    {
        $names = [
            'BTC' => 'Bitcoin',
            'ETH' => 'Ethereum',
            'USDT' => 'Tether USD',
            'BNB' => 'Binance Coin',
            'LTC' => 'Litecoin',
            'DOGE' => 'Dogecoin',
            'XRP' => 'Ripple',
            'TRX' => 'Tron',
            'BCH' => 'Bitcoin Cash'
        ];

        return $names[$this->currency] ?? $this->currency;
    }

    // Get truncated address for display
    public function getTruncatedAddressAttribute()
    {
        if (!$this->address) return null;
        
        return substr($this->address, 0, 6) . '...' . substr($this->address, -6);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function transactionsCount()
    {
        return $this->transactions()->count();  
    }

    public function accountsCount()
    {
        return $this->where('user_id', $this->user_id)->count();  
    }
}