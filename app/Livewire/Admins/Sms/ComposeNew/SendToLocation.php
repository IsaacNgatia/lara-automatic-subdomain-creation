<?php

namespace App\Livewire\Admins\Sms\ComposeNew;

use App\Livewire\Forms\Sms\SendToLocationForm;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SendToLocation extends Component
{
    public SendToLocationForm $sendToLocationForm;
    public $locations;
    public $sendToAll = false;
    public $sendToActive = false;
    public $sendToInactive = false;
    public $recipients = 0;

    public function mount()
    {
        // Fetch distinct locations with their IDs and format them as required
        $this->locations = Customer::whereNotNull('location')
            ->select('location')
            ->groupBy('location') // Ensure uniqueness based on the location
            ->get()
            ->map(function ($customer) {
                return [
                    'location' => $customer->location,
                ];
            })
            ->toArray();

        // Set form statuses
        $this->sendToLocationForm->activeStatus = $this->sendToActive;
        $this->sendToLocationForm->inactiveStatus = $this->sendToInactive;
    }

    public function updatedSendToAll($value)
    {
        if ($value) {
            // Select all options
            $this->loadAllLocations();
        } else {
            // Clear selection
            $this->sendToLocationForm->selectedLocations = [];
        }

        // Emit an event to update Choices.js
        $this->dispatch('sendToGroup', $this->sendToLocationForm->selectedLocations);
    }
    public function updatedSendToActive($value)
    {
        if ($value) {
            $this->sendToInactive = false;
            if ($this->sendToLocationForm->selectedLocations == []) {
                $locationsWithActiveUsers = $this->loadLocationsWithActiveUsers();
                $this->sendToLocationForm->selectedLocations = $locationsWithActiveUsers;
            }
        } else {
            $this->sendToLocationForm->selectedLocations = [];
        }

        $this->dispatchSendToGroupEvent($this->sendToLocationForm->selectedLocations);
    }
    public function updatedSendToInactive($value)
    {
        if ($value) {
            $this->sendToActive = false;
            if ($this->sendToLocationForm->selectedLocations == []) {
                $locationsWithInactiveUsers = $this->loadLocationsWithInactiveUsers();
                $this->sendToLocationForm->selectedLocations = $locationsWithInactiveUsers;
            }
        } else {
            $this->sendToLocationForm->selectedLocations = [];
        }

        $this->dispatchSendToGroupEvent($this->sendToLocationForm->selectedLocations);
    }
    private function loadLocationsWithActiveUsers()
    {
        return Customer::whereNotNull('location')
            ->where('status', 'active')
            ->select('location')
            ->groupBy('location') // Ensure uniqueness based on the location
            ->get()
            ->map(function ($customer) {
                return [
                    'location' => $customer->location,
                ];
            })
            ->toArray();
    }

    private function loadLocationsWithInactiveUsers()
    {
        return Customer::whereNotNull('location')
            ->where('status', 'inactive')
            ->select('location')
            ->groupBy('location') // Ensure uniqueness based on the location
            ->get()
            ->map(function ($customer) {
                return [
                    'location' => $customer->location,
                ];
            })
            ->toArray();
    }

    private function loadAllLocations()
    {
        $this->sendToLocationForm->selectedLocations = Customer::whereNotNull('location')
            ->where('status', 'inactive')
            ->select('location')
            ->groupBy('location') // Ensure uniqueness based on the location
            ->get()
            ->map(function ($customer) {
                return [
                    'location' => $customer->location,
                ];
            })
            ->toArray();
    }
    private function dispatchSendToGroupEvent($locations)
    {
        $this->dispatch('sendToGroup', $locations);
    }
    public function submitForm()
    {
        $this->sendToLocationForm->activeStatus = $this->sendToActive;
        $this->sendToLocationForm->inactiveStatus = $this->sendToInactive;
        $this->sendToLocationForm->validate();
        // Sending message to users
        $result = $this->sendToLocationForm->sendToLocations();
        if ($result['status'] == 'success') {
            session()->flash('success', $result['message']);
            $this->dispatch('reset-multi-select');
            $this->sendToLocationForm->reset();
            $this->sendToAll = false;
            $this->sendToActive = false;
            $this->sendToInactive = false;
        } else {
            session()->flash('resultError', $result['message']);
        }
    }

    public function render()
    {
        return view('livewire.admins.sms.compose-new.send-to-location');
    }
}
