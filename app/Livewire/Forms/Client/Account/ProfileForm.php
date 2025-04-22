<?php

namespace App\Livewire\Forms\Client\Account;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileForm extends Form
{
    #[Validate('required')]
    public $name;
    #[Validate('required')]
    public $house_number;
    #[Validate('required|email')]
    public $email;
    #[Validate('required')]
    public $phone_number;
    // #[Validate('required')]
    public $monthly_bill;
    // #[Validate('required')]
    public $status;

    public function save()
    {
        try {
            // $customer = Customer::update([
            //     'complaint_id' => $this->complaintId,
            //     'reply' => $this->reply,
            //     'replied_by' => auth()->guard('client')->user()->id,
            // ]);
            return true;
        } catch (\Throwable $th) {
            dd($th);
            $this->addError('status', 'Failed to update.');
            return $th->getMessage();
        }
    }
}
