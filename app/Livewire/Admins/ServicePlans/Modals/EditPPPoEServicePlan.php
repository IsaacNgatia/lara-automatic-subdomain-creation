<?php

namespace App\Livewire\Admins\ServicePlans\Modals;

use App\Models\Mikrotik;
use App\Models\ServicePlan;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;

class EditPPPoEServicePlan extends Component
{
    public $routerStatus = false;
    public $pppoeProfiles = [];
    public $checkingStatus = true;
    public $eventToBeDispatched;
    public $servicePlan;
    public $name;
    public $profile;
    public $billing_cycle;
    public $price;
    public $mikrotikId;

    public function mount($id, $eventToBeDispatched = 'close-modal')
    {
        try {
            $this->servicePlan = ServicePlan::findOrFail($id);
            $this->name = $this->servicePlan->name;
            $this->profile = $this->servicePlan->profile;
            $this->price = $this->servicePlan->price;
            $this->billing_cycle = $this->servicePlan->billing_cycle;
            $this->mikrotikId = $this->servicePlan->mikrotik_id;
            $this->eventToBeDispatched = $eventToBeDispatched;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'PPPoE package not found.');
            return redirect()->route('services.all');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while fetching the package details.');
            return redirect()->route('services.all');
        }
    }

    public function closeModal()
    {
        $this->dispatch('cancel-update-service-plan');
    }

    public function render()
    {
        return view('livewire.admins.service-plans.modals.edit-p-p-po-e-service-plan');
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

    public function updateServicePlan()
    {
        try {
            $this->servicePlan->update([
                'name' => $this->name,
                'profile' => $this->profile,
                'price' => $this->price,
                'billing_cycle' => $this->billing_cycle,
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
}
