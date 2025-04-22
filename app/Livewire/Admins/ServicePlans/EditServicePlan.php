<?php

namespace App\Livewire\Admins\ServicePlans;

use App\Models\ServicePlan;
use Livewire\Component;

class EditServicePlan extends Component
{
    public $selectedServicePlan;
    public $servicePlan;
    public $name;
    public $profile;
    public $rate_limit;
    public $price;
    public $is_active;
    public $isOpen = false;
    public $pppoeProfiles;
    public $userProfiles;
    protected $listeners = ["editServicePlan"];
    public function editServicePlan($id, $pppoeProfiles, $userProfiles)
    {
        $this->servicePlan = ServicePlan::findOrFail($id);
        $this->selectedServicePlan = $this->servicePlan;
        $this->name = $this->servicePlan->name;
        $this->profile = $this->servicePlan->profile;
        $this->rate_limit = $this->servicePlan->rate_limit;
        $this->price = $this->servicePlan->price;
        $this->is_active = $this->servicePlan->is_active;
        $this->isOpen = true;

        $this->userProfiles = $userProfiles;
        $this->pppoeProfiles = $pppoeProfiles;

    }

    public function updateServicePlan()
    {
        // dd($this->servicePlan);
        try {
            ServicePlan::where('id', $this->servicePlan->id)->update([
                'name' => $this->name,
                'profile' => $this->profile,
                'rate_limit' => $this->rate_limit,
                'price' => $this->price,
                'is_active' => $this->is_active,
            ]);

            $this->dispatch(event: 'open-static-success-message');
            session()->flash('success', 'Package updated successfully');

            // Wait for two seconds before closing modal
            sleep(2);
            $this->dispatch(event: 'close-modal');

            $this->emit('service-plan-updated');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function resetFields()
    {
        $this->servicePlan = null;
        $this->name = '';
        $this->profile = '';
        $this->rate_limit = '';
        $this->price = '';
        $this->is_active = '';
        $this->isOpen = 'false';
    }
    public function render()
    {
        return view('livewire.admins.service-plans.edit-service-plan');
    }
}
