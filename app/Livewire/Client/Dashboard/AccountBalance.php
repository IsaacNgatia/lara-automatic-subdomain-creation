<?php

namespace App\Livewire\Client\Dashboard;

use App\Models\Customer;
use Livewire\Component;

class AccountBalance extends Component
{
    public $accountBalance = 0;
    public $customer;
    public function mount()
    {
        $this->customer = Customer::where('id', auth()->guard('client')->user()->id)->first();
        $this->accountBalance = $this->customer->balance;
    }
    public function render()
    {
        return view('livewire.client.dashboard.account-balance');
    }
}
