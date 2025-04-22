<?php

namespace App\Livewire\Admins\Isp;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\PppoeUser;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAllPppoeUsers extends Component
{
    use WithPagination;
    private $pppoeUsers;
    public $perPage;
    public $search;
    public $totalPppoeUsers;
    public $updatingId;
    public $deletingId;
    public function mount()
    {
        $this->perPage = 10;
        $this->totalPppoeUsers = PppoeUser::count();
    }
    public function editPppoeUser($id)
    {
        $this->updatingId = $id;
        $this->dispatch('open-modal');
    }
    public function warn($id)
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal');
    }
    #[On('cancel-update-pppoe-user')]
    public function cancelUpdatePppoeUser()
    {
        $this->dispatch('close-modal');
        $this->updatingId = null;
    }
    #[On('delete-pppoe-user')]
    public function deletePppoeUser()
    {
        $customer  = Customer::find($this->deletingId);
        $connect = Mikrotik::getLoginCredentials($customer->mikrotik_id);
        $data = ['name' => $customer->pppoeUser->mikrotik_name];
        $mikrotikResponse = PppoeUser::deletePppoeUser($connect, $data);
        if ($mikrotikResponse) {
            $customer->pppoeUser->delete();
            $customer->delete();
            $this->dispatch('pppoe-user-activity-complete');
        }
    }
    #[On('cancel-delete-pppoe-user')]
    public function cancelDeletePppoeUser()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
    }
    #[On('pppoe-user-activity-complete')]
    public function pppoeActivityComplete()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
        $this->updatingId = null;
    }
    public function render()
    {
        $search = $this->search;
        $this->pppoeUsers = DB::table('customers')
            ->where('connection_type', 'pppoe')
            ->join('pppoe_users', 'customers.id', '=', 'pppoe_users.customer_id')
            ->join('mikrotiks', 'customers.mikrotik_id', '=', 'mikrotiks.id')
            ->select(
                'customers.id',
                'customers.official_name',
                'customers.mikrotik_id',
                'customers.reference_number',
                'customers.billing_amount',
                'customers.billing_cycle',
                'customers.phone_number',
                'customers.status',
                'customers.expiry_date',
                'pppoe_users.mikrotik_name',
                'pppoe_users.profile',
                'pppoe_users.password',
                'mikrotiks.name as mikrotik_identity'
            )
            ->where(function ($query) use ($search) {
                $query->where('customers.official_name', 'like', '%' . $search . '%')
                    ->orWhere('customers.location', 'like', '%' . $search . '%')
                    ->orWhere('customers.reference_number', 'like', '%' . $search . '%')
                    ->orWhere('customers.phone_number', 'like', '%' . $search . '%')
                    ->orWhere('pppoe_users.mikrotik_name', 'like', '%' . $search . '%')
                    ->orWhere('pppoe_users.profile', 'like', '%' . $search . '%')
                    ->orWhere('mikrotiks.name', 'like', '%' . $search . '%');
            })
            ->paginate($this->perPage);
        return view('livewire.admins.isp.view-all-pppoe-users', [
            'pppoeUsers' => $this->pppoeUsers,
        ]);
    }
}
