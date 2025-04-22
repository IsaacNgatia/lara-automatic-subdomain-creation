<?php

namespace App\Livewire\Admins\Sms\Modal;

use App\Models\Admin;
use App\Models\SmsTemplate;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddSmsTemplate extends Component
{
    #[Validate('required')]
    public $subject;
    #[Validate('required')]
    public $template;
    public $subjectList = [
        ['value' => 'hsp_message', 'title' => 'HSP Message', 'description' => 'Sent to Hotspot Clients'],
        ['value' => 'ticket_raised', 'title' => 'Ticket Raised', 'description' => 'Sent to Admins after Ticket has been Raised'],
        ['value' => 'ticket_admin_reply', 'title' => 'Ticket Admin Reply', 'description' => 'Sent to Clients after Ticket has been Replied'],
        ['value' => 'ticket_client_reply', 'title' => 'Ticket Client Reply', 'description' => 'Sent to Admins after Ticket has been Replied'],
        ['value' => 'ticket_closed', 'title' => 'Ticket Closed', 'description' => 'Sent to Clients after Ticket has been Closed'],
        ['value' => 'welcome', 'title' => 'Welcome Message', 'description' => 'Sent to Clients after account has been created'],
        ['value' => 'acknowledgement', 'title' => 'Acknowledgement Message', 'description' => 'Sent to Clients after making a Payment'],
    ];

    public function addTemplate()
    {
        $this->validate();

        try {
            // Create the scheduled SMS entry
            $save = SmsTemplate::create([
                'subject' => $this->subject,
                'template' => $this->template,
                'created_by' => auth()->guard('admin')->user()->id
            ]);

            // Dispatch success event and flash success message
            $this->dispatch('success-saving-template');
            session()->flash('success', 'Expiry SMS Template added successfully.');

            // Reset all form fields
            $this->reset(['template']);
        } catch (\Exception $e) {
            // Log the error (for debugging)
            Log::error('Error saving SMS template: ' . $e->getMessage());
            dd($e->getMessage());

            // Dispatch error event and flash error message
            $this->dispatch('error-saving-template');
            session()->flash('resultError', 'Failed to save SMS template. Please try again.');
        }
    }
    public function render()
    {
        return view('livewire.admins.sms.modal.add-sms-template');
    }
}
