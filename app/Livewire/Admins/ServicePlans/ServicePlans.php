<?php

namespace App\Livewire\Admins\ServicePlans;

use App\Models\Mikrotik;
use App\Models\ServicePlan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class ServicePlans extends Component
{
    use WithPagination;

    public $updatingId;
    public $servicePlan;
    public $servicePlanType;
    public $name;
    public $profile;
    public $rate_limit;
    public $price;
    public $is_active;
    public $type;
    public $isOpen = false;
    public $deletingId;
    public $pppoeProfiles;
    public $userProfiles;

    public function mount($pppoeProfiles = [], $userProfiles = [])
    {
        $this->userProfiles = $userProfiles;
        $this->pppoeProfiles = $pppoeProfiles;
    }
    public function editServicePlan($id)
    {
        $this->updatingId = $id;
        $this->servicePlanType = ServicePlan::where('id', $id)->first()->type;
        $this->dispatch('open-modal');
    }

    public function warn($id)
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal');
    }
    #[On('delete-package')]
    public function deleteServicePlan()
    {
        $servicePlan = ServicePlan::findOrFail($this->deletingId);
        $connect = Mikrotik::getLoginCredentials($servicePlan->mikrotik_id);
        $servicePlan->delete();
        $this->dispatch('service-plan-activity-complete');
    }

    #[On('service-plan-activity-complete')]
    public function servicePlanActivityComplete()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
        // $this->updatingId = null;
    }
    #[On('open-static-success-message')]
    public function refreshServicePlans()
    {
        $this->render();
    }

    public function render()
    {
        $servicePlans = ServicePlan::query()
            ->paginate(10);
        return view(
            'livewire.admins.service-plans.service-plans',
            [
                'servicePlans' => $servicePlans
            ]
        );
    }
}
