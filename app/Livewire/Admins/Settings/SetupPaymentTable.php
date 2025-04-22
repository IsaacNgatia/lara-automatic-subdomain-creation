<?php

namespace App\Livewire\Admins\Settings;

use App\Models\PaymentConfig;
use Livewire\Component;

class SetupPaymentTable extends Component
{
    public $paymentConfigs;
    public function mount(){
        $this->paymentConfigs = PaymentConfig::all();
    }
    public function render()
    {
        return view('livewire.admins.settings.setup-payment-table');
    }
}
