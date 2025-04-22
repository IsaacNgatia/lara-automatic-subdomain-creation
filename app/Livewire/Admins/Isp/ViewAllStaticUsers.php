<?php

namespace App\Livewire\Admins\Isp;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\StaticUser;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAllStaticUsers extends Component
{
    use WithPagination;
    private $staticUsers;
    public $perPage = 10;
    public $totalStaticUsers;
    public $search;
    public $updatingId;
    public $deletingId;
    public function mount()
    {
        $this->totalStaticUsers = StaticUser::count();
        // $this->staticUsers = DB::table('customers')
        //     ->where('connection_type', 'static')
        //     ->join('static_users', 'customers.id', '=', 'static_users.customer_id')
        //     ->join('mikrotiks', 'customers.mikrotik_id', '=', 'mikrotiks.id')
        //     ->select('customers.id', 'customers.official_name', 'customers.mikrotik_id', 'customers.reference_number', 'customers.billing_amount', 'customers.billing_cycle', 'customers.phone_number', 'customers.status', 'customers.expiry_date', 'static_users.mikrotik_name', 'static_users.max_download_speed', 'static_users.target_address','mikrotiks.name as mikrotik_identity')
        //     ->get() ?? [];
    }
    public function editStaticUser($id)
    {
        $this->updatingId = $id;
        $this->dispatch('open-modal');
    }
    public function warn($id)
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal');
    }
    #[On('cancel-update-static-user')]
    public function cancelUpdateStaticUser()
    {
        $this->dispatch('close-modal');
        $this->updatingId = null;
    }
    #[On('delete-static-user')]
    public function deleteStaticUser()
    {
        $customer  = Customer::find($this->deletingId);
        $connect = Mikrotik::getLoginCredentials($customer->mikrotik_id);
        $data = ['name' => $customer->staticUser->mikrotik_name];
        $mikrotikResponse = StaticUser::deleteStaticUser($connect, $data);
        if ($mikrotikResponse) {
            $customer->staticUser->delete();
            $customer->delete();
            $this->dispatch('static-user-activity-complete');
        }
    }
    #[On('cancel-delete-static-user')]
    public function cancelDeleteStaticUser()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
    }
    #[On('static-user-activity-complete')]
    public function staticActivityComplete()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
        $this->updatingId = null;
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function render()
    {
        $search = $this->search;
        $this->staticUsers = DB::table('customers')
            ->where('connection_type', 'static')
            ->join('static_users', 'customers.id', '=', 'static_users.customer_id')
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
                'static_users.mikrotik_name',
                'static_users.max_download_speed',
                'static_users.target_address',
                'mikrotiks.name as mikrotik_identity'
            )
            ->where(function ($query) use ($search) {
                $query->where('customers.official_name', 'like', '%' . $search . '%')
                    ->orWhere('customers.location', 'like', '%' . $search . '%')
                    ->orWhere('static_users.mikrotik_name', 'like', '%' . $search . '%')
                    ->orWhere('mikrotiks.name', 'like', '%' . $search . '%');
            })
            ->paginate($this->perPage);
        return view('livewire.admins.isp.view-all-static-users', [
            'staticUsers' => $this->staticUsers,
        ]);
    }
}
