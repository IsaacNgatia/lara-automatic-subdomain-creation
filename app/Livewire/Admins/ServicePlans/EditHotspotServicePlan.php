<?php

namespace App\Livewire\Admins\ServicePlans;

use App\Livewire\Forms\ServicePlans\CreateHotspot;
use Livewire\Component;

class EditHotspotServicePlan extends Component
{
    public CreateHotspot $createHotspotServicePlanForm;
    public $userProfiles;

    public function mount($routerId,  $userProfiles)
    {
        $this->userProfiles = $userProfiles;
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->createHotspotServicePlanForm->routerId = $routerId;
    }

    public function createHotspotServicePlan()
    {
        $this->createHotspotServicePlanForm->validate();
        $result = $this->createHotspotServicePlanForm->save();

        if ($result == true) {
            $this->createHotspotServicePlanForm->reset([
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
        return view('livewire.admins.service-plans.edit-hotspot-service-plan');
    }
}
