<?php

namespace App\Livewire\Forms\Admin\Hotspot;

use App\Models\Mikrotik;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class HotspotSwitcherForm extends Form
{
    #[Rule('required')]
    public $userType = 'pppoe';
    #[Rule('required')]
    public $routerId;
    public $submitted = false;
    public $routerStatus = false;
    // public $pppoeProfiles = [];


    public function submit()
    {
        $this->validate();
        $this->submitted = true;
        $mikrotik = Mikrotik::find(id: $this->routerId);
        // $connect = [
        //     'ip' => $mikrotik->ip,
        //     'port' => $mikrotik->port,
        //     'user' => $mikrotik->user,
        //     'password' => $mikrotik->password
        // ];
        $connect = Mikrotik::getLoginCredentials(($this->routerId));
        if ($this->userType === 'pppoe') {
            return Mikrotik::fetchPppoeProfiles($connect);
        } else if ($this->userType === 'static') {
            $this->routerStatus = Mikrotik::checkRouterStatus($connect);
            return true;
        } else if ($this->userType === 'hotspot') {
            return Mikrotik::fetchHspDetails($connect);
        }
        return false;

    }
    public function fetchHotspotDetails(){
        $this->validate();
        $connect = Mikrotik::getLoginCredentials(($this->routerId));
        return Mikrotik::fetchHspDetails($connect);
    }
}
