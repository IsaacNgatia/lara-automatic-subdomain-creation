<?php

namespace App\Livewire\Forms\admins\mikrotiks;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Mikrotik;

class AddMikrotikForm extends Form
{
    #[Validate('required|ip')]
    public $ip;
    #[Validate('required|string')]
    public $user;
    #[Validate('required|string')]
    public $password;
    #[Validate('required|integer|unique:mikrotiks,port')]
    public $port;
    #[Validate('required|string')]
    public $name;
    #[Validate('required|string')]
    public $location;

    public function store()
    {
        $this->validate();

        $mikrotik = Mikrotik::create($this->all());
        $mikrotik->save();
    }
}
