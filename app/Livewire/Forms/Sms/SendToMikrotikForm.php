<?php

namespace App\Livewire\Forms\Sms;

use App\Services\SmsService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SendToMikrotikForm extends Form
{
    #[Validate('required')]
    public $selectedMikrotiks;
    #[Validate('required')]
    public $textMessage;
    public $inactiveStatus;
    public $activeStatus;
    public function sendToMikrotiks()
    {
        try {
            $smsService = app(SmsService::class);
            // Send SMS to selected users
            return $smsService->send(['mikrotiks' => $this->selectedMikrotiks, 'inactive' => $this->inactiveStatus, 'active' => $this->activeStatus], $this->textMessage, 'composed message to mikrotiks');
        } catch (\Throwable $th) {
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
