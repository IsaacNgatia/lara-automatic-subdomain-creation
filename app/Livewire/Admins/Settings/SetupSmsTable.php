<?php

namespace App\Livewire\Admins\Settings;

use App\Models\SmsConfig;
use Livewire\Component;

class SetupSmsTable extends Component
{
    public $smsConfigs;
    public function mount(){
        $this->smsConfigs = SmsConfig::all();
    }
    public function render()
    {
        return view('livewire.admins.settings.setup-sms-table');
    }
}
