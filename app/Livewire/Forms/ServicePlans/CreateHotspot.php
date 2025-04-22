<?php

namespace App\Livewire\Forms\ServicePlans;

use App\Models\ServicePlan;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateHotspot extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $profile;
    #[Validate('required')]
    public $price;
    public $is_active = true;
    #[Validate('required')]
    public $billing_cycle;
    public $routerId;
    public function save()
    {
        try {
            ServicePlan::create([
                'name' => $this->name,
                'type' => 'rhsp',
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
