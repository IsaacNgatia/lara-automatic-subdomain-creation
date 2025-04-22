<?php

namespace App\Livewire\Admins\ServicePlans;

use App\Livewire\Forms\ServicePlans\CreateStatic;
use App\Models\ServicePlan;
use Livewire\Component;

class EditStaticServicePlan extends Component
{
    public CreateStatic $createStaticServicePlanFormm;

    public function mount($routerId)
    {
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->createStaticServicePlanFormm->routerId = $routerId;
    }

    public function createStaticServicePlan()
    {
        $this->createStaticServicePlanFormm->validate();
        $result = $this->createStaticServicePlanFormm->save();
        if ($result == true) {
            $this->createStaticServicePlanFormm->reset([
                'name',
                'rate_limit',
                'price',
                'billing_cycle'
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
        return view('livewire.admins.service-plans.edit-static-service-plan');
    }
}
