<?php

namespace App\Livewire\Client;

use App\Models\Complaint;
use Livewire\Component;

class Support extends Component
{
    public $topic;
    // public string $topic = '';
    // public string $description = '';
    public $description;

    public  $tickets;

    public Complaint $ticket;

    public function mount()
    {
        $this->tickets = Complaint::where('customer_id', auth()->guard('client')->user()->id)->get();
        $this->ticket = Complaint::where('customer_id', auth()->guard('client')->user()->id)->first();
    }

    public function render()
    {
        return view('livewire.client.support')->layout('livewire.client.layouts.master');
    }

    public function createTicket(SmsService)
    {
       try {
            $tn = Complaint::count() + 1;
            $ticket = Complaint::create([
                // TODO::Add Type
                // 'type' => $request->type,
                'topic'  => $this->topic,
                'description'  => $this->description,
                'customer_id'  => auth()->guard('client')->user()->id,
                'case_number' => "TKT-" . $tn,
            ]);

            if($ticket){

            }

            return redirect()->route('client.support')->with(['success' => 'Ticket sent successfully']);
        } catch (\Throwable $th) {
            dd($th);
            // return redirect()->back()->with(['error' => 'Error sending ticket']);
            //throw $th;
        }
    }
}
