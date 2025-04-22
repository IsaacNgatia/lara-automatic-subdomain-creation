<?php

namespace App\Livewire\Forms\Sms;

use App\Services\SmsService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SendToUserForm extends Form
{
    #[Validate('required')]
    public $selectedUsers = [];
    #[Validate('required')]
    public $textMessage = 'Hello {official_name}, your account is {reference_number}. Kindly pay {bill} before {expiry_date}. The number we have is {phone}. if you want to change reach out using {user_url}.';

    public function sendMessage()
    {
        try {
            $smsService = app(SmsService::class);
            // Send SMS to selected users
            return $smsService->send(['id' => $this->selectedUsers], $this->textMessage, 'composed message to users');
        } catch (\Throwable $th) {
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
