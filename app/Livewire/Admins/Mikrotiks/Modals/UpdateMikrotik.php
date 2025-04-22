<?php

namespace App\Livewire\Admins\Mikrotiks\Modals;

use App\Models\Mikrotik;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UpdateMikrotik extends Component
{
    public $selectedId;
    #[Validate('required|ip')]
    public $ip;
    #[Validate('required')]
    public $user;
    public $password;
    #[Validate('required|unique:mikrotiks,name')]
    public $name;
    public $location;
    public $recipient;
    public $nat;
    public $queueTypes;
    public function mount($id)
    {
        $this->selectedId = $id;
        $selectedMikrotik = Mikrotik::find($id);
        $this->ip = $selectedMikrotik->ip;
        $this->user = $selectedMikrotik->user;
        $this->password = $selectedMikrotik->password;
        $this->name = $selectedMikrotik->name;
        $this->location = $selectedMikrotik->location;
        $this->recipient = $selectedMikrotik->recipient;
        $this->nat = $selectedMikrotik->nat;
        $this->queueTypes = $selectedMikrotik->queue_types;
    }
    public function update()
    {
        $this->validate();
        $mikrotik = Mikrotik::find($this->selectedId);
        $mikrotik->update([
            'ip' => $this->ip,
            'user' => $this->user,
            'password' => $this->password,
            'name' => $this->name,
            'location' => $this->location,
            'recipient' => $this->recipient,
            'nat' => $this->nat,
            'queue_types' => $this->queueTypes
        ]);
        session()->flash('message', 'Mikrotik Updated Successfully');
        $this->dispatch('updated-mikrotik');
    }
    public function render()
    {
        return view('livewire.admins.mikrotiks.modals.update-mikrotik');
    }
}
