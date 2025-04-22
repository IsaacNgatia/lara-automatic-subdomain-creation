<?php

namespace App\Livewire\Admins\Isp;

use App\Livewire\Forms\isp\IspFormSwitcher as IspIspFormSwitcher;
use Livewire\Component;
use App\Services\RouterosApiService;
use App\Models\Mikrotik;
use App\Models\Customer;


class IspFormSwitcher extends Component
{
    public $selectedRouter;
    protected $routerosApiService;
    public $routerStatus = false;
    public IspIspFormSwitcher $switcher;
    public $router = '';
    public $pppoeProfiles = [];
    public $hspServers = [];
    public $hspUserProfiles = [];
    public $submitted = false;
    public $routers;
    public $errorMessage;

    public function mount()
    {
        $this->switcher->userType = 'static';
        $this->switcher->router = Mikrotik::latest()->first()->id ?? null;
        $this->routers = Mikrotik::orderBy('id', 'desc')->get();
    }

    public function getRouterStatusIcon($routerId)
    {
        // $status = $this->routerStatus[$routerId] ?? 'pending';
        $status = 'pending';
        $iconPaths = [
            'success' => 'build/assets/images/svg/green-tick.png',
            'failed' => 'build/assets/images/svg/red-failed.png',
            'pending' => 'build/assets/images/svg/spinning-dots.svg'
        ];

        return asset($iconPaths[$status]);
    }

    public function checkRouterStatus()
    {
        $this->switcher->validate();
        $this->submitted = true;
        if ($this->switcher->userType == 'static') {
            $this->routerStatus = $this->switcher->submit();
        } else if ($this->switcher->userType == 'pppoe') {
            $this->pppoeProfiles = $this->switcher->submit();
            $this->routerStatus = $this->pppoeProfiles !== false;
        } else if ($this->switcher->userType == 'hotspot') {
            $submitResponse = $this->switcher->submit();
            $this->hspServers = $submitResponse['servers'] ?? null;
            $this->hspUserProfiles = $submitResponse['user-profiles'] ?? null;
            $this->routerStatus = $submitResponse !== false;
        }

        if (!$this->routerStatus) {
            $this->submitted = false;
            $this->errorMessage = " The router failed to connect. Ensure the router is online and click the button below to synchronize.";
        }
    }

    public function render()
    {
        return view('livewire.admins.isp.isp-form-switcher');
    }
}
