<?php

namespace App\Livewire\Forms\ServicePlans;

use App\Models\ServicePlan;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateStatic extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $rate_limit;
    #[Validate('required')]
    public $price;
    #[Validate('required')]
    public $billing_cycle;
    public $routerId;
    public $is_active;
    public function save()
    {
        try {
            ServicePlan::create([
                'name' => $this->name,
                'type' => 'static',
                'rate_limit' => $this->rate_limit,
                'price' => $this->price,
                'is_active' => true,
                'billing_cycle' => $this->billing_cycle,
                'mikrotik_id' => $this->routerId,
            ]);
            return true;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
