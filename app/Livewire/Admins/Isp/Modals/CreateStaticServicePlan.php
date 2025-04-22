<?php

namespace App\Livewire\Admins\Isp\Modals;

use App\Livewire\Forms\ServicePlans\CreateStatic;
use App\Models\ServicePlan;
use Livewire\Component;

class CreateStaticServicePlan extends Component
{
    public CreateStatic $createStaticServicePlanFormm;

    public function mount($routerId)
    {
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->createStaticServicePlanFormm->routerId = $routerId;
    }
    public function render()
    {
        return view('livewire.admins.isp.modals.create-static-service-plan');
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
                'is_active',
            ]);
            $this->dispatch('open-static-success-message');
            session()->flash('success', 'Service plan  created successfully');
        } else {
            $this->dispatch('open-static-error-message');
            session()->flash('resultError', "Error creating plan");
        }
    }
}
