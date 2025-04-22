<?php

namespace App\Livewire\Admins\Sms\ComposeNew;

use App\Livewire\Forms\Sms\SendToUserForm;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class SendToUser extends Component
{
    public SendToUserForm $sendToUsersForm;
    public $customers;
    public $sendToAll = false;
    public $sendToActive = false;
    public $sendToInactive = false;
    public function mount()
    {
        // Eager load relationships if necessary
        $this->customers = Customer::query()
            ->select('id', 'official_name', 'status')
            ->get();
    }
    public function updatedSendToAll($value)
    {
        if ($value) {
            // Select all options
            $this->sendToUsersForm->selectedUsers = Customer::all()->pluck('id')->toArray();
        } else {
            // Clear selection
            $this->sendToUsersForm->selectedUsers = [];
        }

        // Emit an event to update Choices.js
        $this->dispatch('sendToGroup', $this->sendToUsersForm->selectedUsers);
    }
    public function updatedSendToActive($value)
    {
        $activeUsers = $this->loadActiveUsers();
        if ($value) {
            $this->sendToUsersForm->selectedUsers = $activeUsers->pluck('id')->toArray();
        } else {
            $this->sendToUsersForm->selectedUsers = [];
        }

        $this->dispatchSendToGroupEvent($this->sendToUsersForm->selectedUsers);
    }
    public function updatedSendToInactive($value)
    {
        $inactiveUsers = $this->loadInactiveUsers();
        if ($value) {
            $this->sendToUsersForm->selectedUsers = $inactiveUsers->pluck('id')->toArray();
        } else {
            $this->sendToUsersForm->selectedUsers = [];
        }

        $this->dispatchSendToGroupEvent($this->sendToUsersForm->selectedUsers);
    }

    private function loadActiveUsers(): Collection
    {
        return Customer::where('status', 'active')
            ->select('id', 'official_name', 'status')
            ->get();
    }
    private function loadInactiveUsers(): Collection
    {
        return Customer::where('status', 'inactive')
            ->select('id', 'official_name', 'status')
            ->get();
    }

    private function dispatchSendToGroupEvent($users): void
    {
        $this->dispatch('sendToGroup', $users);
    }
    public function submitForm()
    {
        $this->sendToUsersForm->validate();
        // Sending message to users
        $result = $this->sendToUsersForm->sendMessage();
        if ($result['status'] == 'success') {

            session()->flash('success', $result['message']);
            $this->dispatch('reset-multi-select');
            $this->sendToUsersForm->reset();
            $this->sendToAll = false;
            $this->sendToActive = false;
            $this->sendToInactive = false;
        } else {
            session()->flash('resultError', $result['message']);
        }
    }

    public function render()
    {
        return view('livewire.admins.sms.compose-new.send-to-user');
    }
}
