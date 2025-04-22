<?php

namespace App\Livewire\Client\Support\Modals;

use App\Livewire\Forms\Client\Tickets\NewTicketForm;
use App\Models\Sms;
use Livewire\Component;

class NewClientTicket extends Component
{
    public NewTicketForm $newTicketForm;

    public function createNewTicket(){
        $this->newTicketForm->validate();

        $saveResult = $this->newTicketForm->save();

        if ($saveResult) {
            session()->flash('success', 'Ticket created successfully.');
            $this->newTicketForm->reset();
            $this->dispatch('ticket-created');

            // TODO::Add this block when provider is added

            // try {
            //     $response = Sms::sendSupportSMS(
            //         ['phone' => '0706506361'], 
            //         'This is a test message.', 
            //         'Test Subject'
            //     );

            //     dd($response);
            // } catch (\Throwable $th) {
            //     dd($th);
            // }
        } else {
            session()->flash('error', 'Failed to create ticket.');
        }
    }

    public function render()
    {
        return view('livewire.client.support.modals.new-client-ticket');
    }
}
