<?php

namespace App\Livewire\Admins\Customers;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\PppoeUser;
use App\Models\StaticUser;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ViewAllCustomers extends Component
{
    use WithPagination;
    private $customers;
    public $perPage;
    public $search;
    public $totalCustomers;
    public $updatingId;
    public $selectedUserType;
    public $deletingId;
    public function mount()
    {
        $this->perPage = 10;
        $this->totalCustomers = Customer::count();
    }
    public function editCustomer($id, $userType)
    {
        $this->updatingId = $id;
        $this->selectedUserType = $userType;
        $this->dispatch('open-modal');
    }
    public function warn($id, $userType)
    {
        $this->deletingId = $id;
        $this->selectedUserType = $userType;
        $this->dispatch('open-modal');
    }
    #[On('cancel-update-customer')]
    public function cancelUpdateCustomer()
    {
        $this->dispatch('close-modal');
        $this->updatingId = null;
        $this->selectedUserType = null;
    }
    #[On('delete-customer')]
    public function deleteCustomer()
    {
        $customer = Customer::find($this->deletingId);

        if (!$customer) {
            return; // Exit if the customer does not exist
        }
        $connect = Mikrotik::getLoginCredentials($customer->mikrotik_id);

        if ($this->selectedUserType == 'pppoe') {
            $data = ['name' => $customer->pppoeUser->mikrotik_name];
            $mikrotikResponse = PppoeUser::deletePppoeUser($connect, $data);
        } else if ($this->selectedUserType == 'static') {
            $data = ['name' => $customer->staticUser->mikrotik_name];
            $mikrotikResponse = StaticUser::deleteStaticUser($connect, $data);
        }

        if ($mikrotikResponse === true) {
            if ($this->selectedUserType == 'pppoe') {
                // Delete the associated PPPoE user
                $customer->pppoeUser->delete();
            } else if ($this->selectedUserType == 'static') {
                $customer->staticUser->delete();
            }
            // Delete the customer entry
            $customer->delete();

            // Dispatch event to notify completion
            $this->dispatch(event: 'customer-activity-complete');
        }
    }

    #[On('cancel-delete-customer')]
    public function cancelDeletePppoeUser()
    {
        $this->dispatch('close-modal');
        $this->selectedUserType = null;
        $this->deletingId = null;
    }
    #[On('customer-activity-complete')]
    public function pppoeActivityComplete()
    {
        $this->deletingId = null;
        $this->updatingId = null;
    }
    #[On('close-modal')]
    public function closeModal()
    {
        $this->pppoeActivityComplete();
    }

    public function getInitials($name)
    {
        $name = explode(' ', $name);
        $initials = '';
        foreach ($name as $n) {
            $initials .= strtoupper($n[0]);
        }
        return $initials;
    }
    public function render()
    {
        $search = $this->search;

        $this->customers = DB::table('customers')
            ->leftJoin('pppoe_users', function ($join) {
                $join->on('customers.id', '=', 'pppoe_users.customer_id')
                    ->where('customers.connection_type', 'pppoe');
            })
            ->leftJoin('static_users', function ($join) {
                $join->on('customers.id', '=', 'static_users.customer_id')
                    ->where('customers.connection_type', 'static');
            })
            ->leftJoin('hotspot_recurrings', function ($join) {
                $join->on('customers.id', '=', 'hotspot_recurrings.customer_id')
                    ->where('customers.connection_type', 'rhsp');
            })
            ->leftJoin('mikrotiks', 'customers.mikrotik_id', '=', 'mikrotiks.id')
            ->select(
                'customers.id',
                'customers.official_name',
                'customers.mikrotik_id',
                'customers.reference_number',
                'customers.connection_type',
                'customers.billing_amount',
                'customers.billing_cycle',
                'customers.phone_number',
                'customers.status',
                'customers.expiry_date',
                'mikrotiks.name AS mikrotik_identity',
                DB::raw('
                CASE
                    WHEN customers.connection_type = "pppoe" THEN pppoe_users.mikrotik_name
                    WHEN customers.connection_type = "static" THEN static_users.mikrotik_name
                    WHEN customers.connection_type = "rhsp" THEN hotspot_recurrings.mikrotik_name
                    ELSE NULL
                END AS mikrotik_name
            ')
            )
            ->where(function ($query) use ($search) {
                $query->where('customers.official_name', 'like', '%' . $search . '%')
                    ->orWhere('customers.location', 'like', '%' . $search . '%')
                    ->orWhere('customers.reference_number', 'like', '%' . $search . '%')
                    ->orWhere('customers.phone_number', 'like', '%' . $search . '%')
                    ->orWhere('customers.connection_type', 'like', '%' . $search . '%')
                    ->orWhere('mikrotiks.name', 'like', '%' . $search . '%')
                    ->orWhere('pppoe_users.mikrotik_name', 'like', '%' . $search . '%')
                    ->orWhere('static_users.mikrotik_name', 'like', '%' . $search . '%')
                    ->orWhere('hotspot_recurrings.mikrotik_name', 'like', '%' . $search . '%');
            })
            ->orderBy('customers.id', 'desc') // Ordering by `id` in descending order
            ->paginate($this->perPage);
        return view('livewire.admins.customers.view-all-customers', [
            'customers' => $this->customers,
        ]);
    }
}
