<?php

namespace App\Livewire\Admins\Sms;

use App\Models\SmsTemplate as ModelsSmsTemplate;
use Livewire\Attributes\On;
use Livewire\Component;

class SmsTemplate extends Component
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
        $this->totalTemplatesCount = ModelsSmsTemplate::count();
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
        $smsTemplate  = ModelsSmsTemplate::find($this->deletingId);
        if ($smsTemplate) {
            $smsTemplate->delete();
            $this->dispatch('close-modal');
        }
    }
    public function render()
    {
        $allTemplates = ModelsSmsTemplate::when($this->search, function ($query) {
            $query->where('subject', 'like', '%' . $this->search . '%')
                ->orWhere('template', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.admins.sms.sms-template', ['allTemplates' => $allTemplates]);
    }
}
