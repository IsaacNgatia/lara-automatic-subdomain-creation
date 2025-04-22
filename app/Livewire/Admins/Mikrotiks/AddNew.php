<?php

namespace App\Livewire\Admins\Mikrotiks;


use App\Livewire\Forms\admins\mikrotiks\AddMikrotikForm;
use Livewire\Component;

class AddNew extends Component
{
    public AddMikrotikForm $form;
    public function submitForm()
    {
        $this->form->validate();
        // Creating new mikrotik
        $this->form->store();

        session()->flash('success', 'mikrotik created successfully');
        $this->form->reset();
    }
    public function openSetupPublicIpModal()
    {
        $this->dispatch('open-modal');
    }
    public function render()
    {
        return view('livewire.admins.mikrotiks.add-new');
    }
}
