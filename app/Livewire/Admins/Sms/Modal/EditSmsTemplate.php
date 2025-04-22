<?php

namespace App\Livewire\Admins\Sms\Modal;

use App\Models\SmsTemplate;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditSmsTemplate extends Component
{
    #[Validate('required')]
    public $subject;
    #[Validate('required')]
    public $template;
    public $smsTemplateId;
    public $subjectList = [
        ['value' => 'hsp_message', 'title' => 'HSP Message', 'description' => 'Sent to Hotspot Clients'],
        ['value' => 'ticket_raised', 'title' => 'Ticket Raised', 'description' => 'Sent to Admins after Ticket has been Raised'],
        ['value' => 'ticket_admin_reply', 'title' => 'Ticket Admin Reply', 'description' => 'Sent to Clients after Ticket has been Replied'],
        ['value' => 'ticket_client_reply', 'title' => 'Ticket Client Reply', 'description' => 'Sent to Admins after Ticket has been Replied'],
        ['value' => 'ticket_closed', 'title' => 'Ticket Closed', 'description' => 'Sent to Clients after Ticket has been Closed'],
        ['value' => 'welcome', 'title' => 'Welcome Message', 'description' => 'Sent to Clients after account has been created'],
        ['value' => 'acknowledgement', 'title' => 'Acknowledgement Message', 'description' => 'Sent to Clients after making a Payment'],
    ];
    public function mount($id)
    {
        $smsTemplate = SmsTemplate::findOrFail($id);
        $this->smsTemplateId = $id;
        $this->subject = $smsTemplate->subject;
        $this->template = $smsTemplate->template;
    }
    // public function updatedDayToSend($value)
    // {
    //     if ($value === 0) {
    //         $this->beforeAfter = 'n/a';
    //         // $this->render();
    //     }
    // }

    public function updateTemplate()
    {
        $this->validate();

        try {
            $smsTemplate = SmsTemplate::find($this->smsTemplateId);
            // Create the scheduled SMS entry
            $smsTemplate->update([
                'subject' => $this->subject,
                'template' => $this->template,
            ]);

            // Dispatch success event and flash success message
            session()->flash('success', 'Expiry SMS Template updated successfully.');
            $this->dispatch('close-modal');
        } catch (\Exception $e) {
            // Log the error (for debugging)
            Log::error('Error updating SMS template: ' . $e->getMessage());

            // Dispatch error event and flash error message
            $this->dispatch('error-saving-template');
            session()->flash('resultError', 'Failed to update SMS template. Please try again.');
        }
    }
    public function render()
    {
        return view('livewire.admins.sms.modal.edit-sms-template');
    }
}
