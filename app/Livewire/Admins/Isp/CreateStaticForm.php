<?php

namespace App\Livewire\Admins\Isp;

use App\Livewire\Forms\isp\CreateStatic;
use App\Models\Customer;
use App\Models\ServicePlan;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


class CreateStaticForm extends Component
{
    public CreateStatic $staticForm;
    public $phoneSelected;

    public $customerProfiles;

    public $servicePlans;

    public $isDisabled = false;

    public $rId;

    public function mount($routerId)
    {
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $this->staticForm->expiryDate = now(env('APP_TIMEZONE', 'Africa/Nairobi'))->timezone($timezone)->addMonth()->endOfDay()->format('Y-m-d\TH:i');
        $this->staticForm->routerId = $routerId;
        // $this->staticForm->status = 'yes';
        $this->staticForm->billingCycle = 'months';
        $this->staticForm->billingCycleValue = '1';
        $this->staticForm->sendEmail = false;
        $this->staticForm->sendSms = false;

        $this->customerProfiles = Customer::where('parent_account', NULL)->get();
        $this->servicePlans = ServicePlan::where('type', 'static')->get();

        $this->rId = $routerId;

        $this->isDisabled = false;
    }

    #[On('open-static-success-message')]
    public function refreshServicePlans()
    {
        $this->servicePlans = ServicePlan::where('type', 'static')->get();
    }
    public function createStaticUser()
    {
        $this->staticForm->validate();
        $result = $this->staticForm->create();
        if ($result === true) {
            $this->staticForm->reset([
                'username',
                'officialName',
                'email',
                'password',
                'ip',
                'location',
                'maxLimit',
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
            $this->dispatch('open-static-success-message');
            session()->flash('success', 'Static user created successfully');
        } else {
            $this->dispatch('open-static-error-message');
            session()->flash('resultError', $result);
        }
    }
    function generateUniqueReferenceNumber()
    {
        if ($this->phoneSelected === false && $this->staticForm->phone && $this->staticForm->phone != '' && !$this->isPhoneAlreadyUsedAsReferenceNumber($this->staticForm->phone)) {
            $this->phoneSelected = true;
            $this->staticForm->referenceNumber = str_replace(['+', ' ', '-'], '', $this->staticForm->phone);
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
            $this->staticForm->referenceNumber = $referenceNumber;
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
        return view('livewire.admins.isp.create-static-form');
    }

    public function addStaticServicePlan()
    {
        $this->dispatch('open-modal');
    }
    public function updated($property)
    {
        if ($property == 'staticForm.billingCycle' || $property == 'staticForm.billingCycleValue') {
            $this->staticForm->expiryDate =
                match ($this->staticForm->billingCycle) {
                    'days' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'weeks' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addWeeks((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'months' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addMonths((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'years' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addYears((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    default => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays(30)->endOfDay()->format('Y-m-d\TH:i'),
                };
        }

        if ($property == 'staticForm.service_plan_id') {

            $servicePlan = ServicePlan::findOrFail($this->staticForm->service_plan_id);

            $this->staticForm->bill = $servicePlan->price;
            $this->staticForm->billingCycle = $servicePlan->billing_cycle;
            $this->staticForm->expiryDate =
                match ($this->staticForm->billingCycle) {
                    'days' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'weeks' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addWeeks((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'months' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addMonths((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    'years' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addYears((int)$this->staticForm->billingCycleValue)->endOfDay()->format('Y-m-d\TH:i'),
                    default => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays(30)->endOfDay()->format('Y-m-d\TH:i'),
                };
        }

        if ($property == 'staticForm.is_parent') {
            $this->isDisabled = !$this->isDisabled;
        }
    }
}
