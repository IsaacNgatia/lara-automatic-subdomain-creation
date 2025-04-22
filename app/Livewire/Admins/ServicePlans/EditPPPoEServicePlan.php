<?php

namespace App\Livewire\Admins\ServicePlans;

use App\Livewire\Forms\ServicePlans\CreatePPPoE;
use App\Models\ServicePlan;
use Livewire\Component;

class EditPPPoEServicePlan extends Component
{
    public CreatePPPoE $createPPPoEServicePlanForm;
    public $pppoeProfiles;

    public function mount($routerId,  $pppoeProfiles)
    {
        $this->pppoeProfiles = $pppoeProfiles;
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->createPPPoEServicePlanForm->routerId = $routerId;
    }

    public function createPPPoEervicePlan()
    {
        $this->createPPPoEServicePlanForm->validate();
       $result = $this->createPPPoEServicePlanForm->save();

        if ($result == true) {
            $this->createPPPoEServicePlanForm->reset([
                'name',
                'profile',
                'price',
                'is_active',
            ]);
            $this->dispatch('open-static-success-message');
            session()->flash('success', 'Service plan  created successfully');
        } else {
            $this->dispatch('open-static-error-message');
            session()->flash('resultError', "Error creating plan");
        }
    }
    public function render()
    {
        return view('livewire.admins.service-plans.edit-p-p-po-e-service-plan');
    }
}
