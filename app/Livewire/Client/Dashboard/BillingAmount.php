<?php

namespace App\Livewire\Client\Dashboard;

use App\Models\Customer;
use Livewire\Component;

class BillingAmount extends Component
{
    public $customer;
    public function mount()
    {
        $this->customer = Customer::where('id', auth()->guard('client')->user()->id)->first();
    }
    public function render()
    {
        return view('livewire.client.dashboard.billing-amount');
    }
}
