<?php

namespace App\Livewire\User;

use App\Models\PaymentMethod;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Deposit extends Component
{
    public $amount;
    public $selectedMethod;
    public $paymentMethods;
    public $recentDeposits;

    protected $rules = [
        'amount' => 'required|numeric|min:10|max:10000',
        'selectedMethod' => 'required|exists:payment_methods,id'
    ];

    public function mount()
    {
        $this->paymentMethods = PaymentMethod::where('status', 'active')->get()->toArray();
        $this->recentDeposits = Transaction::where('user_id', Auth::id())
            ->where('type', 'deposit')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($transaction) {
                return [
                    'id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency,
                    'status' => $transaction->status,
                    'status_color' => $this->getStatusColor($transaction->status),
                    'created_at' => $transaction->created_at,
                    'reference' => $transaction->reference
                ];
            })
            ->toArray();
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function processDeposit()
    {
        $this->validate();

        // Process the deposit based on the selected method
        try {
            // Your deposit processing logic here
            // This would typically integrate with a payment gateway
            
            // Create transaction record
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'type' => 'deposit',
                'amount' => $this->amount,
                'currency' => 'USD',
                'payment_method_id' => $this->selectedMethod,
                'status' => 'pending',
                'reference' => 'DEP' . time() . Auth::id()
            ]);

            // Redirect to payment gateway or show success message
            session()->flash('success', 'Deposit initiated successfully!');
            
            // Reset form
            $this->reset(['amount', 'selectedMethod']);
            
            // Refresh recent deposits
            $this->mount();

        } catch (\Exception $e) {
            session()->flash('error', 'Error processing deposit: ' . $e->getMessage());
        }
    }

    public function addPaymentMethod()
    {
        // Redirect to payment method addition page
        return "TODO: Implement redirection to payment method addition page";
    }

    public function viewAllTransactions()
    {
        // Redirect to transactions page
        return redirect()->route('user.transactions');
    }

    private function getStatusColor($status)
    {
        switch ($status) {
            case 'completed':
                return 'success';
            case 'pending':
                return 'warning';
            case 'failed':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    public function render()
    {
        return view('livewire.user.deposit');
    }
}
