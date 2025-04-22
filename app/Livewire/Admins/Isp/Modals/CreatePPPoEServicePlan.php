<?php

namespace App\Livewire\Admins\Isp\Modals;

use Livewire\Component;
use App\Livewire\Forms\ServicePlans\CreatePPPoE;
use App\Models\Mikrotik;
use Livewire\Attributes\On;

class CreatePPPoEServicePlan extends Component
{
    public CreatePPPoE $createPPPoEServicePlanForm;
    public $mikrotikId;
    public $routerStatus = false;
    public $pppoeProfiles = [];
    public $checkingStatus = true;

    public function mount($routerId)
    {
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->createPPPoEServicePlanForm->routerId = $routerId;
        $this->mikrotikId = $routerId;
    }

    public function createPPPoEServicePlan()
    {
        $this->createPPPoEServicePlanForm->validate();
        $result = $this->createPPPoEServicePlanForm->save();
        if ($result == true) {
            $this->createPPPoEServicePlanForm->reset([
                'name',
                'profile',
                'price',
                'billing_cycle',
            ]);
            $this->dispatch('open-pppoe-success-message');
            session()->flash('success', 'Package  created successfully');
        } else {
            $this->dispatch('open-pppoe-error-message');
            session()->flash('resultError', "Error creating package");
        }
    }

    #[On('checkout-status')]
    public function checkRouterStatus()
    {
        // $this->checkingStatus = true;
        $connect = Mikrotik::getLoginCredentials($this->mikrotikId);
        $this->pppoeProfiles = Mikrotik::fetchPppoeProfiles($connect);
        if (!empty($this->pppoeProfiles)) {
            $this->routerStatus = true;
            $this->checkingStatus = false;
            $this->render();
            return true;
        } else {
            $this->checkingStatus = false;
            return false;
        }
    }

    public function render()
    {
        return view('livewire.admins.isp.modals.create-p-p-po-e-service-plan');
    }
}
