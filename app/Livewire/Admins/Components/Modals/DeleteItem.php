<?php

namespace App\Livewire\Admins\Components\Modals;

use Livewire\Component;

class DeleteItem extends Component
{
    public $title;
    public $message;
    public $eventToBeDispatched;
    public $cancelEvent;
    public $list;
    public function mount($title = 'Danger', $message = 'Kindly refresh the page then proceed', $eventToBeDispatched = 'close-modal', $cancelEvent = 'cancel-modal', $list = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->eventToBeDispatched = $eventToBeDispatched;
        $this->cancelEvent = $cancelEvent;
        $this->list = $list;
    }
    public function delete()
    {
        if ($this->eventToBeDispatched) {
            $this->dispatch($this->eventToBeDispatched);
        } else {
            $this->dispatch($this->cancelEvent);
            $this->dispatch('refresh');
        }
    }
    public function cancel()
    {
        $this->dispatch($this->cancelEvent);
    }
    public function render()
    {
        return view('livewire.admins.components.modals.delete-item');
    }
}
