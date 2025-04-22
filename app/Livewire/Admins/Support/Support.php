<?php

namespace App\Livewire\Admins\Support;

use App\Models\Complaint;
use App\Models\ComplaintReply;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Support extends Component
{
    use WithPagination;

    // public $tickets;
    public $deletingId;

    public $selectedTicketId = null;
    public $chatMessages = [];

    public function mount()
    {
        // $this->tickets = Complaint::get();
    }

    private function showModal()
    {
        $this->dispatch('open-modal');
    }
    public function render()
    {
        // $invoices = ModelsInvoice::query()
        //     ->orderByDesc('id')
        //     ->when(! empty($this->search), fn (Builder $q) => $q->where('reference_number', 'like', "%{$this->search}%"))
        //     ->when(
        //         ! empty($this->invoice_status),
        //         fn (Builder $q) => $q->where([
        //             ['due_date', '>', Carbon::today()],
        //             // TODO::change status for filtering
        //             // ["status", 'like', "%{$this->invoice_status}%"],
        //         ]),
        //     )
        //     ->when(! empty($this->payment_status), fn (Builder $q) => $q->where('status', 'like', "%{$this->payment_status}%"))

        //     ->when(! empty($this->startDate), function (Builder $q) {
        //         $q->whereDate('invoice_date', '>=', $this->startDate);
        //     })
        //     ->when(! empty($this->payment_status), fn (Builder $q) => $q->where('status', 'like', "%{$this->payment_status}%"))

        //     ->when(! empty($this->endDate), function (Builder $q) {
        //         $q->whereDate('invoice_date', '<=', $this->endDate);
        //     })
        //     ->paginate(10);

        $tickets = Complaint::paginate(10);
        return view('livewire.admins.support.support', [
            'tickets' => $tickets
        ]);
    }

    // public function loadChat($ticketId)
    // {
    //     $this->selectedTicketId = $ticketId;

    //     // Fetch chat messages related to the ticket
    //     $this->chatMessages = ComplaintReply::where('complaint_id', $ticketId)
    //         ->orderBy('created_at', 'asc')
    //         ->get();
    // }

    public function warn($ticketId)
    {
        $this->deletingId = $ticketId;
        $this->showModal();
    }

    public function markResolved($ticketId)
    {
        // Find the ticket by ID and update the column
        $ticket = Complaint::find($ticketId);
        if ($ticket) {
            $ticket->status = 'closed';
            $ticket->save();
            session()->flash('success', 'Ticket marked as resolved.');
        }
    }

    #[On('delete-ticket')]
    public function deleteTicket()
    {
        // Find the ticket by ID and update the column
        $ticket = Complaint::find($this->deletingId);
        if ($ticket) {
            $ticket->replies()->delete();
            $ticket->delete();
            $this->resetItems();
            $this->render();
        }
    }

    #[On('close-event')]
    public function resetItems()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
    }

    public function replyToTicket($ticketId){
        $this->selectedTicketId = $ticketId;
        $this->showModal();
    }
}
