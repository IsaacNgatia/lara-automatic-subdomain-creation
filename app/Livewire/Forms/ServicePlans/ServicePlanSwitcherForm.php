<?php

namespace App\Livewire\Forms\ServicePlans;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Mikrotik;

class ServicePlanSwitcherForm extends Form
{
    #[Validate('required')]
    public $userType;
    #[Validate('required')]
    public $router;
    public $submitted = false;
    public $routerStatus = false;
    // public $pppoeProfiles = [];


    public function submit()
    {
        $this->submitted = true;
        $connect = Mikrotik::getLoginCredentials(($this->router));
        if ($this->userType === 'pppoe') {
            return Mikrotik::fetchPppoeProfiles($connect);
        } else if ($this->userType === 'static') {
            $this->routerStatus = Mikrotik::checkRouterStatus($connect);
            return Mikrotik::checkRouterStatus($connect);
        } else if ($this->userType === 'hotspot') {
            return Mikrotik::fetchHspDetails($connect);
        }
        return false;

    }
}
