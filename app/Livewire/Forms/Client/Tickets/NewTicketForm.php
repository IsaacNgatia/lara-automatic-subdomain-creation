<?php

namespace App\Livewire\Forms\Client\Tickets;

use App\Models\Complaint;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NewTicketForm extends Form
{
    #[Validate('required')]
    public $topic;
    #[Validate('required')]
    public $description;

    public function save()
    {
        try {
            $tn = Complaint::count() + 1;
            $ticket = Complaint::create([
                // TODO::Add Type
                // 'type' => $request->type,
                'topic'  => $this->topic,
                'description'  => $this->description,
                'customer_id'  => auth()->guard('client')->user()->id,
                'case_number' => "TICKET" . $tn,
            ]);

            return true;
        } catch (\Throwable $th) {
            $this->addError('status', 'Failed to create ticket.');
            return $th->getMessage();
        }
    }
}
