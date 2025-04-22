<?php

namespace App\Livewire\Client\Support;

use App\Livewire\Forms\Client\Tickets\NewTicketReply;
use App\Models\Complaint;
use App\Models\ComplaintReply;
use App\Models\Sms;
use App\Models\TicketType;
use App\Services\SmsService;
use Livewire\Attributes\On;
use Livewire\Component;

class ClientSupport extends Component
{
    // public $tickets;
    public $selectedTicket = null;
    public $selectedTicketReplies = [];
    public $replies = [];
    public $addClientTicket;

    public NewTicketReply $newTicketReply;

    public $complaintId;
    public $reply;

    public function mount()
    {
        // $this->tickets = Complaint::where('customer_id', auth()->guard('client')->user()->id)->get();
        $this->addClientTicket = false;
    }

    private function showModal()
    {
        $this->dispatch('open-modal');
    }

    public function addingClientTicket()
    {
        $this->showModal();
        $this->addClientTicket = true;
    }

    #[On('ticket-created')]
    public function doneCreatingTicket()
    {
        $this->resetItems();
    }

    // #[On('close-event')]
    public function resetItems()
    {
        $this->addClientTicket = false;
        $this->dispatch('close-modal');
        $this->render();
        // $this->deletingId = null;
        // $this->editingId = null;
        // $this->addExpenseType = null;
    }

    public function selectTicket($ticketId)
    {
        $this->selectedTicket = Complaint::findOrFail($ticketId);
        $this->selectedTicketReplies = ComplaintReply::where('complaint_id', $ticketId)->get();
        $this->replies = ComplaintReply::where('complaint_id', $ticketId)->get();
    }

    public function replyAsClient(SmsService $smsService)
    {
        $this->newTicketReply->complaintId = $this->selectedTicket->id;
        $this->newTicketReply->validate();
        $saveResult = $this->newTicketReply->save();

        // Check the save result and display appropriate flash message
        if ($saveResult) {

            session()->flash('success', 'Reply sent successfully.');
            try {
                $response = Sms::sendSms(
                    ['phone' => '0706506361'], 
                    'This is a test message.', 
                    'Test Subject'
                );
            } catch (\Throwable $th) {
                dd($th);
            }
            // $this->newTicketReply->reset();`
            // $this->dispatch('expense-type-created');
        } else {
            session()->flash('error', 'Failed to create expense type.');
        }
    }

    public function render()
    {
        $ticketTypes = TicketType::all();
        $tickets = Complaint::where('customer_id', auth()->guard('client')->user()->id)->get();

        return view('livewire.client.support.client-support', [
            'ticketTypes' => $ticketTypes,
            'tickets' => $tickets
        ]);
    }
}
