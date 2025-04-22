<?php

namespace App\Livewire\Admins\Sms;

use App\Models\Sms;
use Livewire\Component;
use Livewire\WithPagination;

class SentSms extends Component
{
    use WithPagination;
    public $perPage;
    public $search;
    public $totalSmsCount;
    public function mount()
    {
        $this->perPage = 10;
        $this->totalSmsCount = Sms::count();
    }
    public function render()
    {
        // $allSms = DB::table('sms')->latest()->get()->paginate()
        $allSms = Sms::when($this->search, function ($query) {
            $query->where('recipient', 'like', '%' . $this->search . '%')
                ->orWhere('message', 'like', '%' . $this->search . '%')
                ->orWhere('subject', 'like', '%' . $this->search . '%')
                ->orWhere('message_id', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate($this->perPage);
        return view('livewire.admins.sms.sent-sms', ['allSms' => $allSms]);
    }
}
