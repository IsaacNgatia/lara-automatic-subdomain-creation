<?php

namespace App\Livewire\Admins\Support;

use App\Livewire\Forms\Admin\Tickets\TicketReplyForm;
use App\Models\Complaint;
use App\Models\ComplaintReply;
use Livewire\Component;

class AdminSupportReply extends Component
{
    public $ticket;
    public $ticketReplies = [];
    public $reply;
    public $complaintId;
    public TicketReplyForm $ticketReplyForm;

    public function mount($id)
    {
        $this->ticket = Complaint::findOrFail($id);
        $this->ticketReplies = $this->ticket->replies;
        $this->complaintId = $this->ticket->id;
    }

    public function render()
    {
        return view('livewire.admins.support.admin-support-reply');
    }

    public function replyToTicket()
    {
        $this->ticketReplyForm->complaintId = $this->complaintId;
        $this->ticketReplyForm->validate();
        $saveResult = $this->ticketReplyForm->save();

        // Check the save result and display appropriate flash message
        if ($saveResult) {
            session()->flash('success', 'Reply sent successfully.');
            // $this->ticketReplyForm->reset();
            // $this->dispatch('expense-type-created');
        } else {
            session()->flash('error', 'Failed to create expense type.');
        }
    }
}
