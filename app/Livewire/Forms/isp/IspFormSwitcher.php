<?php

namespace App\Livewire\Forms\isp;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Mikrotik;
class IspFormSwitcher extends Form
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
        // $mikrotik = Mikrotik::find(id: $this->router);
        // $connect = [
        //     'ip' => $mikrotik->ip,
        //     'port' => $mikrotik->port,
        //     'user' => $mikrotik->user,
        //     'password' => $mikrotik->password
        // ];
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
