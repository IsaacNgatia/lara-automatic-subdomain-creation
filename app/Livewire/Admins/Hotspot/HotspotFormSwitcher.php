<?php

namespace App\Livewire\Admins\Hotspot;

use App\Livewire\Forms\Admin\Hotspot\HotspotSwitcherForm;
use App\Models\Mikrotik;
use Livewire\Component;

class HotspotFormSwitcher extends Component
{

    public $selectedRouter;
    public $voucherType;
    protected $routerosApiService;
    public $routerStatus = false;
    public HotspotSwitcherForm $hspSwitcher;
    public $router = '';
    public $pppoeProfiles = [];
    public $hspServers = [];
    public $hspUserProfiles = [];
    public $submitted = false;
    public $routers;
    public function mount()
    {
        $this->voucherType = 'epay';
        $this->hspSwitcher->routerId = Mikrotik::latest()->first()->id ?? null;
        $this->router = $this->hspSwitcher->routerId;
        $this->routers = Mikrotik::all();
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
        $connect = Mikrotik::getLoginCredentials(($this->router));
        return Mikrotik::checkRouterStatus($connect);
    }

    public function submitHspSwitcherForm()
    {
        $this->hspSwitcher->userType = $this->voucherType;
        $this->submitted = true;
        $submitResponse = $this->hspSwitcher->fetchHotspotDetails();
        if ($submitResponse && isset($submitResponse['servers']) && isset($submitResponse['user-profiles'])) {
            $this->hspServers = $submitResponse['servers'];
            $this->hspUserProfiles = $submitResponse['user-profiles'];
            $this->routerStatus = true;
        }
        if (empty($submitResponse) || $submitResponse === null) {
            $this->addError('submit', 'Router failed to connect. Please try again later.');
            $this->submitted = false;
        }
    }
    public function render()
    {
        return view('livewire.admins.hotspot.hotspot-form-switcher');
    }
}
