<?php

namespace App\Livewire\Client\Billing;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;

class TransactionHistory extends Component
{
    public function render()
    {
        $transactions = Transaction::query()
            ->orderByDesc('id')
            ->when(
                ! empty($this->search),
                fn(Builder $q) => $q->where('reference_number', 'like', "%{$this->search}%")
            )
            ->paginate(10);
        return view('livewire.client.billing.transaction-history', [
            'transactions' => $transactions
        ]);
    }
}
