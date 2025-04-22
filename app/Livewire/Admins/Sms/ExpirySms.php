<?php

namespace App\Livewire\Admins\Sms;

use App\Models\ScheduledSms;
use Livewire\Attributes\On;
use Livewire\Component;

class ExpirySms extends Component
{
    public $addNewIsOpen = false;
    public $deletingId;
    public $updatingId;
    public $search;
    public $perPage;
    public $totalTemplatesCount;

    public function mount()
    {
        $this->perPage = 10;
        $this->totalTemplatesCount = ScheduledSms::count();
    }
    public function openAddNew()
    {
        $this->addNewIsOpen = true;
        $this->dispatch('open-modal');
    }
    public function editTemplate($id)
    {
        $this->updatingId = $id;
        $this->dispatch('open-modal');
    }
    public function warn($id)
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal');
    }
    #[On('close-modal')]
    public function closeModal()
    {
        $this->addNewIsOpen = false;
        $this->deletingId = null;
        $this->updatingId = null;
    }
    #[On('delete-expense-type')]
    public function deleteSmsTemplate()
    {
        $smsTemplate  = ScheduledSms::find($this->deletingId);
        if ($smsTemplate) {
            $smsTemplate->delete();
            $this->dispatch('close-modal');
        }
    }
    public function render()
    {
        $allTemplates = ScheduledSms::when($this->search, function ($query) {
            $query->where('day_to_send', 'like', '%' . $this->search . '%')
                ->orWhere('before_after', 'like', '%' . $this->search . '%')
                ->orWhere('template', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.admins.sms.expiry-sms', ['allTemplates' => $allTemplates]);
    }
}
