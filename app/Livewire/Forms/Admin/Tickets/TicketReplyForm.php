<?php

namespace App\Livewire\Forms\Admin\Tickets;

use App\Models\ComplaintReply;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TicketReplyForm extends Form
{
    #[Validate('required')]
    public $reply;

    #[Validate('required')]
    public $complaintId;

    public function save()
    {
        try {
            $reply = ComplaintReply::create([
                'complaint_id' => $this->complaintId,
                'reply' => $this->reply,
                'replied_by' => auth()->guard('admin')->user()->id,
            ]);
            return true;
        } catch (\Throwable $th) {
            $this->addError('status', 'Failed to reply.');
            return $th->getMessage();
        }
    }
}
