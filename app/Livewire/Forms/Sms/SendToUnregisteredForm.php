<?php

namespace App\Livewire\Forms\Sms;

use App\Services\SmsService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SendToUnregisteredForm extends Form
{
    #[Validate('required')]
    public $phone;
    #[Validate('required')]
    public $textMessage;

    public function sendToPhone()
    {
        try {
            $smsService = app(SmsService::class);
            return $smsService->send(['phone' => $this->phone], $this->textMessage, 'composed message to unregistered');
        } catch (\Throwable $th) {
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
