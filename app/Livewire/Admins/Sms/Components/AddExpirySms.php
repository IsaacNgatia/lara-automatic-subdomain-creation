<?php

namespace App\Livewire\Admins\Sms\Components;

use App\Models\ScheduledSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddExpirySms extends Component
{
    #[Validate('required')]
    public $dayToSend;
    #[Validate('required')]
    public $beforeAfter;
    #[Validate('required')]
    public $template;
    public function mount()
    {
        $this->dayToSend = 1;
        $this->beforeAfter = 'before';
    }
    public function updatedDayToSend($value)
    {
        if ($value === 0) {
            $this->beforeAfter = 'n/a';
            // $this->render();
        }
    }
    public function addTemplate()
    {
        $this->validate();

        try {
            // Create the scheduled SMS entry
            ScheduledSms::create([
                'day_to_send' => $this->dayToSend,
                'before_after' => $this->beforeAfter,
                'template' => $this->template,
            ]);

            // Dispatch success event and flash success message
            $this->dispatch('success-saving-template');
            session()->flash('success', 'Expiry SMS Template added successfully.');

            // Reset all form fields
            $this->reset(['template']);
        } catch (\Exception $e) {
            // Log the error (for debugging)
            Log::error('Error saving SMS template: ' . $e->getMessage());

            // Dispatch error event and flash error message
            $this->dispatch('error-saving-template');
            session()->flash('resultError', 'Failed to save SMS template. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admins.sms.components.add-expiry-sms');
    }
}
