<?php

namespace App\Livewire\Forms\Sms;

use App\Services\SmsService;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SendToLocationForm extends Form
{
    #[Validate('required')]
    public $selectedLocations;
    #[Validate('required')]
    public $textMessage;
    public $inactiveStatus;
    public $activeStatus;
    public function sendToLocations()
    {
        try {
            $smsService = app(SmsService::class);
            // Send SMS to selected users
            return $smsService->send(['locations' => $this->selectedLocations, 'inactive' => $this->inactiveStatus, 'active' => $this->activeStatus], $this->textMessage, 'composed message to locations');
        } catch (\Throwable $th) {
            return ['status' => 'error', 'message' => $th->getMessage()];
        }
    }
}
