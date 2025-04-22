<?php

namespace App\Livewire\Admins\Sms\ComposeNew;

use App\Livewire\Forms\Sms\SendToMikrotikForm;
use App\Models\Mikrotik;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SendToMikrotik extends Component
{
    public SendToMikrotikForm $sendToMikrotikForm;
    public $mikrotiks;
    public $sendToAll = false;
    public $sendToActive = false;
    public $sendToInactive = false;
    public $recipients = 0;

    public function mount()
    {
        $this->mikrotiks = Mikrotik::has('customers')->with('customers')->get();
        $this->sendToMikrotikForm->activeStatus = $this->sendToActive;
        $this->sendToMikrotikForm->inactiveStatus = $this->sendToInactive;
    }
    public function updatedSendToAll($value)
    {
        if ($value) {
            // Select all options
            $this->loadAllMikrotiks();
        } else {
            // Clear selection
            $this->sendToMikrotikForm->selectedMikrotiks = [];
        }

        // Emit an event to update Choices.js
        $this->dispatch('sendToGroup', $this->sendToMikrotikForm->selectedMikrotiks);
    }
    public function updatedSendToActive($value)
    {
        $mikrotiksWithActiveUsers = $this->loadMikrotiksWithActiveUsers();
        if ($value) {
            $this->sendToMikrotikForm->selectedMikrotiks = $mikrotiksWithActiveUsers->pluck('id')->toArray();
        } else {
            $this->sendToMikrotikForm->selectedMikrotiks = [];
        }

        $this->dispatchSendToGroupEvent($this->sendToMikrotikForm->selectedMikrotiks);
    }
    public function updatedSendToInactive($value)
    {
        $mikrotiksWithInactiveUsers = $this->loadMikrotiksWithInactiveUsers();
        if ($value) {
            $this->sendToMikrotikForm->selectedMikrotiks = $mikrotiksWithInactiveUsers->pluck('id')->toArray();
        } else {
            $this->sendToMikrotikForm->selectedMikrotiks = [];
        }

        $this->dispatchSendToGroupEvent($this->sendToMikrotikForm->selectedMikrotiks);
    }
    private function loadMikrotiksWithActiveUsers(): Collection
    {
        return Mikrotik::whereHas('customers', function ($query) {
            $query->where('status', 'active');
        })->get(['id', 'name']);
    }
    private function loadMikrotiksWithInactiveUsers(): Collection
    {
        return Mikrotik::whereHas('customers', function ($query) {
            $query->where('status', 'inactive');
        })->get(['id', 'name']);
    }
    private function loadAllMikrotiks()
    {
        $mikrotiks = Mikrotik::has('customers')->with('customers')->get();
        $this->sendToMikrotikForm->selectedMikrotiks = $mikrotiks->pluck('id')->toArray();
    }
    private function dispatchSendToGroupEvent($mikrotiks): void
    {
        $this->dispatch('sendToGroup', $mikrotiks);
    }
    public function submitForm()
    {
        $this->sendToMikrotikForm->activeStatus = $this->sendToActive;
        $this->sendToMikrotikForm->inactiveStatus = $this->sendToInactive;
        $this->sendToMikrotikForm->validate();
        // Sending message to users
        $result = $this->sendToMikrotikForm->sendToMikrotiks();
        if ($result['status'] == 'success') {
            session()->flash('success', $result['message']);
            $this->dispatch('reset-multi-select');
            $this->sendToMikrotikForm->reset();
            $this->sendToAll = false;
            $this->sendToActive = false;
            $this->sendToInactive = false;
        } else {
            session()->flash('resultError', $result['message']);
        }
    }
    public function render()
    {
        return view('livewire.admins.sms.compose-new.send-to-mikrotik');
    }
}
