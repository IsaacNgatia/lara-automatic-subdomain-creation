<?php

namespace App\Livewire\Admins\Isp;

use App\Models\Customer;
use App\Models\Mikrotik;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Livewire\Forms\isp\CreatePppoe;
use App\Models\ServicePlan;
use Livewire\Attributes\On;

class CreatePppoeForm extends Component
{
    public CreatePppoe $pppoeForm;
    public $pppoeProfiles;
    public $phoneSelected;
    public $customerProfiles;
    public $servicePlans;
    public $isDisabled = false;
    public $rId;

    /**
     * Initialize the component with necessary data.
     *
     * @param int $routerId The ID of the router to which the PPPoE user will be assigned.
     * @param array $pppoeProfiles An array of available PPPoE profiles.
     *
     * @return void
     */
    public function mount($routerId)
    {
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->pppoeForm->expiryDate = now(env('APP_TIMEZONE', 'Africa/Nairobi'))->timezone($timezone)->addMonth()->endOfDay()->format('Y-m-d\TH:i');
        $this->pppoeForm->routerId = $routerId;
        $this->pppoeForm->service = 'pppoe';
        $this->pppoeForm->status = 'yes';
        $this->pppoeForm->billingCycle = 'months';
        $this->pppoeForm->billingCycleValue = '1';
        $this->phoneSelected = false;
        $this->customerProfiles = Customer::where('parent_account', NULL)->get();
        $this->servicePlans = ServicePlan::where('type', 'pppoe')->get();
        $this->rId = $routerId;
        // $this->pppoeProfiles = $pppoeProfiles;
    }
    public function createPppoeUser()
    {
        $this->pppoeForm->validate();
        $result = $this->pppoeForm->create();
        if ($result == true) {
            $this->pppoeForm->reset([
                'username',
                'officialName',
                'email',
                'password',
                'profile',
                'location',
                'remoteAddress',
                'referenceNumber',
                'bill',
                'phone',
                'comment',
                'sendSms',
                'sendEmail',
                'parentAccount',
                'installationFee',
                'service_plan_id'
            ]);
            $this->dispatch('open-pppoe-success-message');
            session()->flash('success', 'PPPoE user created successfully');
        } else {
            $this->dispatch('open-pppoe-error-message');
            session()->flash('resultError', $result);
        }
    }
    public function generateRandomPassword(): void
    {
        $this->pppoeForm->password = generateRandomSmallAlphaNumeric(8);
    }
    function generateUniqueReferenceNumber()
    {
        if ($this->phoneSelected === false && $this->pppoeForm->phone && $this->pppoeForm->phone != '' && !$this->isPhoneAlreadyUsedAsReferenceNumber($this->pppoeForm->phone)) {
            $this->phoneSelected = true;
            $this->pppoeForm->referenceNumber = str_replace(['+', ' ', '-'], '', $this->pppoeForm->phone);
        } else {
            $referenceNumber = '';
            $exists = true;

            while ($exists) {
                $referenceNumber = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));

                $existingCount = DB::table('customers')
                    ->where('reference_number', $referenceNumber)
                    ->count();

                $exists = $existingCount > 0;
            }
            $this->pppoeForm->referenceNumber = $referenceNumber;
        }
    }
    protected function isPhoneAlreadyUsedAsReferenceNumber(string $phone): bool
    {
        $phoneWithoutFormatting = str_replace(['+', ' ', '-'], '', $phone);
        $existingCount = Customer::where('reference_number', 'like', '%' . substr($phoneWithoutFormatting, -6) . '%')->count();
        return $existingCount > 0;
    }

    public function render()
    {
        return view('livewire.admins.isp.create-pppoe-form');
    }

    public function updated($property)
    {
        if ($property == 'pppoeForm.billingCycle' || $property == 'pppoeForm.billingCycleValue') {
            $this->pppoeForm->expiryDate =
                match ($this->pppoeForm->billingCycle) {
                    'days' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'weeks' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addWeeks((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'months' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addMonths((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'years' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addYears((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    default => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays(30)->endOfDay()->format('Y-m-d\TH:i'),
                };
        }

        if ($property == 'pppoeForm.service_plan_id') {

            $servicePlan = ServicePlan::findOrFail($this->pppoeForm->service_plan_id);

            $this->pppoeForm->bill = $servicePlan->price;
            $this->pppoeForm->billingCycle = $servicePlan->billing_cycle;
            $this->pppoeForm->expiryDate =
                match ($this->pppoeForm->billingCycle) {
                    'days' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'weeks' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addWeeks((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'months' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addMonths((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'years' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addYears((int)$this->pppoeForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    default => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays(30)->endOfDay()->format('Y-m-d\TH:i'),
                };
        }

        if ($property == 'pppoeForm.is_parent') {
            $this->isDisabled = !$this->isDisabled;
        }
    }

    public function addPPPoEServicePlan()
    {
        $this->dispatch('open-modal');
    }

    #[On('open-pppoe-success-message')]
    public function refreshServicePlans()
    {
        $this->servicePlans = ServicePlan::where('type', 'pppoe')->get();
    }
}
