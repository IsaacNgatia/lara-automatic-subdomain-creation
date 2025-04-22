<?php

namespace App\Livewire\Admins\Dashboard;

use App\Models\Transaction;
use Livewire\Component;

class RecentTransactions extends Component
{
    public $transactions;
    /**
     * Mounts the component and retrieves the latest 5 transactions.
     *
     * @return void
     */
    public function mount()
    {
        $this->transactions = Transaction::latest()->take(5)->get();
    }
    public function render()
    {
        return view('livewire.admins.dashboard.recent-transactions');
    }
}
