<?php

namespace App\Livewire\Forms\ServicePlans;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\ServicePlan;

class CreatePPPoE extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $profile;
    #[Validate('required')]
    public $price;
    #[Validate('required')]
    public $is_active = true;
    public $billing_cycle;
    public $routerId;

    public function save()
    {
        try {
            $ServicePlan = ServicePlan::create([
                'name' => $this->name,
                'type' => 'pppoe',
                'profile' => $this->profile,
                'price' => $this->price,
                'is_active' => $this->is_active,
                'mikrotik_id' => $this->routerId,
                'billing_cycle' => $this->billing_cycle,
            ]);
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
