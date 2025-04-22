<?php

namespace App\Livewire\Admins\Sms\Modal;

use App\Models\ScheduledSms;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditExpiryTemplate extends Component
{
    #[Validate('required')]
    public $dayToSend;
    #[Validate('required')]
    public $beforeAfter;
    #[Validate('required')]
    public $template;
    public $smsTemplateId;
    public function mount($id)
    {
        $smsTemplate = ScheduledSms::findOrFail($id);
        $this->smsTemplateId = $id;
        $this->dayToSend = $smsTemplate->day_to_send;
        $this->beforeAfter = $smsTemplate->before_after;
        $this->template = $smsTemplate->template;
    }
    public function updatedDayToSend($value)
    {
        if ($value === 0) {
            $this->beforeAfter = 'n/a';
            // $this->render();
        }
    }
    public function updateTemplate()
    {
        $this->validate();

        try {
            $scheduledSmsTemplate = ScheduledSms::find($this->smsTemplateId);
            // Create the scheduled SMS entry
            $scheduledSmsTemplate->update([
                'day_to_send' => $this->dayToSend,
                'before_after' => $this->beforeAfter,
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
        return view('livewire.admins.sms.modal.edit-expiry-template');
    }
}
