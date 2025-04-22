<?php

namespace App\Livewire\Admins\Sms\ComposeNew;

use App\Livewire\Forms\Sms\SendToUnregisteredForm;
use Livewire\Component;

class SendToUnregistered extends Component
{
    public SendToUnregisteredForm $form;
    public function submitForm()
    {
        $this->form->validate();
        // Sending message to users of the phone number
        $result = $this->form->sendToPhone();
        if ($result['status'] == 'success') {
            session()->flash('success', $result['message']);
            $this->form->reset('phone');
        } else {
            session()->flash('resultError', $result['message']);
        }
    }
    public function render()
    {
        return view('livewire.admins.sms.compose-new.send-to-unregistered');
    }
}
