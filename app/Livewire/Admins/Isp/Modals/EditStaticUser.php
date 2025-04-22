<?php

namespace App\Livewire\Admins\Isp\Modals;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\StaticUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditStaticUser extends Component
{
    #[Validate('required')]
    public $officialName;
    #[Validate('required')]
    public $phone;
    public $email;
    public $location;
    #[Validate('required')]
    public $billingCycle;
    #[Validate('required')]
    public $billingCycleValue;
    #[Validate('required')]
    public $bill;
    #[Validate('required')]
    public $expiryDate;
    public $oldExpiryDate;
    public $referenceNumber;

    // Static specific details
    public $username;
    #[Validate('required')]
    public $ip;
    #[Validate('required')]
    public $maxLimit;
    public $remoteAddress;
    public $status;

    public $customerId;
    public $staticUserId;
    public $mikrotikId;

    // Details from mikrotik
    public $routerStatus = false;
    public $pppoeProfiles = [];
    public $checkingStatus = true;
    public $phoneSelected = false;
    public $eventToBeDispatched;
    public function mount($id, $eventToBeDispatched = 'close-modal')
    {
        try {
            $customer = Customer::with('staticUser')
                ->findOrFail($id);
            $staticUser = $customer->staticUser;
            $mikrotikIdentity = $customer->mikrotik ? $customer->mikrotik->name : null;

            $separatedDuration = $this->separateDuration($customer->billing_cycle);
            // Assign customer details
            $this->customerId = $customer->id;
            $this->officialName = $customer->official_name;
            $this->phone = $customer->phone_number;
            $this->email = $customer->email;
            $this->location = $customer->location;
            $this->billingCycle = $separatedDuration['unit'];
            $this->billingCycleValue = $separatedDuration['value'];
            $this->bill = $customer->billing_amount;
            $this->expiryDate = Carbon::parse($customer->expiry_date)->format('Y-m-d\TH:i');
            $this->oldExpiryDate = $this->expiryDate;
            $this->referenceNumber = $customer->reference_number;

            // Assign PPPoE user details
            $this->staticUserId = $staticUser->id;
            $this->username = $staticUser->mikrotik_name;
            $this->ip = $staticUser->target_address;
            $this->maxLimit = $staticUser->max_download_speed;

            // Details from the mikrotik
            $this->mikrotikId = $customer->mikrotik_id;

            $this->eventToBeDispatched = $eventToBeDispatched;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Static user not found.');
            return redirect()->route('isp.static');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while fetching the user details.');
            return redirect()->route('isp.static');
        }
    }

    public function rules()
    {
        return [
            'referenceNumber' => [
                'required',
                Rule::unique('customers', 'reference_number')->ignore($this->customerId),
            ],
            'username' => [
                'required',
                Rule::unique('static_users', 'mikrotik_name')->ignore($this->staticUserId),
            ],
        ];
    }
    public function updateStaticUser()
    {
        // Perform validation
        $this->validate();
        try {
            //code...

            $staticUser = StaticUser::find($this->staticUserId);
            $customer = Customer::find($this->customerId);
            $comment = $this->username . ' has been updated at ' . now(env('TIME_ZONE'))->format('d-m-Y H:i:s') . " by " . request()->ip();
            $this->checkDateTimeStatus($this->expiryDate);
            if (
                $this->expiryDate != $this->oldExpiryDate ||
                $this->username != $staticUser->mikrotik_name ||
                $this->maxLimit != $staticUser->max_download_speed ||
                $this->ip != $staticUser->target_address
            ) {

                $connect = Mikrotik::getLoginCredentials($this->mikrotikId);
                $data = [
                    'target-address' => $this->ip,
                    'status' => $this->status,
                    'max-limit' => $this->maxLimit,
                    'comment' => $comment,
                ];
                if ($this->username != $staticUser->mikrotik_name) {
                    $data['new-name'] = $this->username;
                    $data['old-name'] = $staticUser->mikrotik_name;
                    $comment = $this->username . ' has been updated to ' . $staticUser->mikrotik_name . ' at ' . now(env('TIME_ZONE'))->format('d-m-Y H:i:s') . " by " . request()->ip();
                    $data['comment'] = $comment;

                    $mikrotikUpdate = StaticUser::updateStaticMikrotikName($connect, $data);
                } else {
                    $data['name'] = $this->username;
                    $data['comment'] = $comment;
                    $mikrotikUpdate = StaticUser::updateStaticUser($connect, $data);
                }
                if ($mikrotikUpdate === true) {
                    session()->flash('success', 'Mikrotik updated successfully. Updating the database ...');
                } else if ($mikrotikUpdate == 'Undefined array key 0') {
                    return session()->flash('resultError', 'The user is not in the mikrotik');
                } elseif ($mikrotikUpdate === false) {
                    return session()->flash('resultError', 'Router is now connected to the internet');
                } else {
                    return session()->flash('resultError', 'There has been an error updating the user');
                }
            }

            // Update customer details
            if ($customer) {
                $customer->update([
                    'official_name' => $this->officialName,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'location' => $this->location,
                    'billing_cycle' => $this->getBillingCycle($this->billingCycle, $this->billingCycleValue),
                    'billing_amount' => $this->bill,
                    'expiry_date' => $this->expiryDate,
                    'reference_number' => $this->referenceNumber,
                ]);
            } else {
                throw new ModelNotFoundException('Customer not found.');
            }

            // Update Static user details
            if ($staticUser) {
                $staticUser->update([
                    'mikrotik_name' => $this->username,
                    'target_address' => $this->ip,
                    'max_download_speed' => $this->maxLimit,
                    'comment' => $comment,
                ]);
                session()->flash('success', 'User updated succesfully.');
                $this->dispatch('static-user-activity-complete');
            } else {
                throw new ModelNotFoundException('Static user not found.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    /**
     * Separates the duration value from the unit in a given input string.
     *
     * This function uses regular expressions to extract the integer value and the duration unit from the input string.
     * If the input string does not match the expected format, the function returns null.
     *
     * @param string $input The input string containing the duration value and unit.
     *
     * @return array|null An associative array containing the 'value' and 'unit' of the duration, or null if the input is invalid.
     *
     * @throws \Exception If an error occurs during the regular expression matching.
     */
    function separateDuration($input)
    {
        // Use regex to separate the integer value from the duration unit
        preg_match('/(\d+)\s*(\w+)/', $input, $matches);

        // Check if we got a match
        if (count($matches) < 3) {
            return null; // Invalid input
        }

        $value = $matches[1];
        $unit = strtolower($matches[2]);

        // Make the unit plural if it's not already and value is not 1
        if (substr($unit, -1) !== 's') {
            $unit .= 's';
        }

        return ['value' => $value, 'unit' => $unit];
    }
    /**
     * Checks the status of the router and fetches PPPoE profiles.
     *
     * This function connects to the router using the provided Mikrotik ID, fetches the PPPoE profiles,
     * and updates the component's properties accordingly.
     *
     * @return bool Returns true if PPPoE profiles are fetched successfully, false otherwise.
     *
     * @throws \Exception If an error occurs while fetching the PPPoE profiles.
     */
    #[On('checkout-status')]
    public function checkRouterStatus()
    {
        // $this->checkingStatus = true;
        $connect = Mikrotik::getLoginCredentials($this->mikrotikId);
        if (Mikrotik::checkRouterStatus($connect)) {
            $this->routerStatus = true;
            $this->checkingStatus = false;
            $this->render();
            return true;
        } else {
            $this->checkingStatus = false;
            return false;
        }
    }
    /**
     * Generates a unique reference number for a customer.
     *
     * If the phone number is not already used as a reference number, it replaces the reference number with the phone number.
     * If the phone number is already used, it generates a random alphanumeric reference number of length 6.
     *
     * @return void
     *
     * @throws \Exception If an error occurs while querying the database.
     */
    function generateUniqueReferenceNumber()
    {
        if ($this->phoneSelected === false && $this->phone && $this->phone != '' && !$this->isPhoneAlreadyUsedAsReferenceNumber($this->phone)) {
            $this->phoneSelected = true;
            $this->referenceNumber = str_replace(['+', ' ', '-'], '', $this->phone);
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
            $this->referenceNumber = $referenceNumber;
        }
    }
    /**
     * Checks if the provided phone number is already used as a reference number in the customers table.
     *
     * @param string $phone The phone number to check.
     * @return bool Returns true if the phone number is already used as a reference number, false otherwise.
     *
     * @throws \Exception If an error occurs while querying the database.
     */
    protected function isPhoneAlreadyUsedAsReferenceNumber(string $phone): bool
    {
        // Remove formatting from the phone number
        $phoneWithoutFormatting = str_replace(['+', ' ', '-'], '', $phone);

        // Query the database to check if the phone number is already used as a reference number
        $existingCount = Customer::where('reference_number', 'like', '%' . substr($phoneWithoutFormatting, -6) . '%')->count();

        // Return true if the phone number is already used, false otherwise
        return $existingCount > 0;
    }
    public function closeModal()
    {
        $this->dispatch('cancel-update-static-user');
    }
    private function getBillingCycle(string $billingCycle, int $billingCycleValue): string
    {
        $cycles = [
            "days" => "day",
            "weeks" => "week",
            "months" => "month",
            "years" => "year",
        ];

        return $billingCycleValue . ' ' . ($billingCycleValue > 1 ? $cycles[$billingCycle] . 's' : $cycles[$billingCycle]);
    }
    public function checkDateTimeStatus($datetime)
    {
        $date = Carbon::parse($datetime);

        $this->status = $date->isPast() ? 'no' : 'yes';
    }
    public function render()
    {
        return view('livewire.admins.isp.modals.edit-static-user');
    }
}
