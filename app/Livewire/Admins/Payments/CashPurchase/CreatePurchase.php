<?php

namespace App\Livewire\Admins\Payments\CashPurchase;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePurchase extends Component
{
    public $customer;
    public $mikrotikInfo;
    #[Validate('required')]
    public $customerId;
    public $phone;
    #[Validate('required')]
    public $amount;
    public $comment;

    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $this->customer = Customer::find($customerId);
        if ($this->customer->connection_type === 'pppoe') {
            $this->mikrotikInfo = $this->customer->pppoeUser;
        } elseif ($this->customer->connection_type === 'static') {
            $this->mikrotikInfo = $this->customer->staticUser;
        } elseif ($this->customer->connection_type === 'rhsp') {
            $this->mikrotikInfo = $this->customer->recurringHotspotUser;
        }
    }
    public function createPurchase()
    {
        $this->validate();
        $result = Customer::processCashPurchaseDeposit($this->amount, $this->customerId, $this->comment);
        if ($result['success'] === true) {
            session()->flash('success', $result['message']);
        } else {
            session()->flash('resultError', $result['message']);
        }
    }
    public function render()
    {
        return view('livewire.admins.payments.cash-purchase.create-purchase');
    }
}
