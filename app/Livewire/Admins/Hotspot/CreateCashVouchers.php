<?php

namespace App\Livewire\Admins\Hotspot;

use App\Livewire\Forms\Admin\Hotspot\CashVouchersForm;
use Livewire\Component;

class CreateCashVouchers extends Component
{
    public $servers;
    public $userProfiles;
    public CashVouchersForm $hotspotForm;
    public $dataLimitSelected;
    public $timeLimitSelected;
    public $lengthSelected;

    public function mount($servers, $userProfiles, $routerId)
    {
        $this->servers = $servers;
        $this->hotspotForm->routerId = $routerId;
        $this->userProfiles = $userProfiles;
        $this->hotspotForm->passwordStatus = 1;
        $this->dataLimitSelected = 'MBs';
        $this->hotspotForm->datalimit = $this->dataLimitSelected;
        $this->timeLimitSelected = 'minutes';
        $this->hotspotForm->timelimit = $this->timeLimitSelected;
        $this->lengthSelected = '6';
        $this->hotspotForm->voucherLength = $this->lengthSelected;
    }
    public function createHotspotUser()
    {
        $this->hotspotForm->validate();
        try {
            $result = $this->hotspotForm->create();
            if ($result == true) {
                session()->flash('success', $this->hotspotForm->quantity . ' Hotspot vouchers created successfully');
                $this->hotspotForm->reset();
            } else {
                session()->flash('error', $result);
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            session()->flash('error', 'Error creating hotspot voucher: ' . $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admins.hotspot.create-cash-vouchers');
    }
}
