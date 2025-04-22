<?php

namespace App\Livewire\Admins\Mikrotiks;

use App\Models\Mikrotik;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAll extends Component
{
    use WithPagination;
    public $selectedId;
    public $id = 1;
    public $perPage;
    private $allMikrotiks;
    public $query;
    public $totalMikrotiks;
    public function mount()
    {
        $this->perPage = 10;
        $this->allMikrotiks = Mikrotik::paginate($this->perPage);
        $this->totalMikrotiks = Mikrotik::count();
    }
    #[On('updated-mikrotik')]
    public function succesful()
    {
        $this->dispatch('close-modal');
        $this->selectedId = null;
    }
    public function editMikrotik($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal');
    }

    public function delete(Mikrotik $mikrotikId)
    {
        $mikrotikId->delete();
    }
    public function render()
    {
        $this->allMikrotiks = Mikrotik::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('location', 'like', '%' . $this->query . '%')
            ->orWhere('user', 'like', '%' . $this->query . '%')
            ->paginate($this->perPage);
        return view('livewire.admins.mikrotiks.view-all', [
            'mikrotiks' => $this->allMikrotiks,
        ]);
    }
}
