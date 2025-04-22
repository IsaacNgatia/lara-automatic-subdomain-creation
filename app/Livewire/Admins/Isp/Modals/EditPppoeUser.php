<?php

namespace App\Livewire\Admins\Isp\Modals;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\PppoeUser;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class EditPppoeUser extends Component
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

    // PPPoE specific details
    public $password;
    public $username;
    #[Validate('required')]
    public $status;
    #[Validate('required')]
    public $selectedProfile;
    #[Validate('required')]
    public $service;
    public $remoteAddress;

    public $customerId;
    public $pppoeUserId;
    public $mikrotikId;
    public $checkingStatus = false;
    // Details from mikrotik
    public $routerStatus = false;
    public $pppoeProfiles = [];
    public $phoneSelected = false;
    public $eventToBeDispatched;
    public function mount($id, $eventToBeDispatched = 'close-modal')
    {
        try {
            $customer = Customer::with('pppoeUser')
                ->findOrFail($id);
            $pppoeUser = $customer->pppoeUser;
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
            $this->pppoeUserId = $pppoeUser->id;
            $this->password = $pppoeUser->password;
            $this->username = $pppoeUser->mikrotik_name;
            $this->status = $customer->status == 'active' ? 'yes' : 'no';
            $this->selectedProfile = $pppoeUser->profile;
            $this->service = $pppoeUser->service;
            $this->remoteAddress = $pppoeUser->remote_address;
            $this->pppoeProfiles = [['.id' => 1, 'name' => $this->selectedProfile]];

            // Details from the mikrotik
            $this->mikrotikId = $customer->mikrotik_id;

            $this->eventToBeDispatched = $eventToBeDispatched;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'PPPoE user not found.');
            return redirect()->route('isp.pppoe');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while fetching the user details.');
            return redirect()->route('isp.pppoe');
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
                Rule::unique('pppoe_users', 'mikrotik_name')->ignore($this->pppoeUserId),
            ],
        ];
    }
    public function updatePppoeUser()
    {
        // Perform validation
        $this->validate();
        $pppoeUser = PppoeUser::find($this->pppoeUserId);
        $customer = Customer::find($this->customerId);
        $comment = $this->username . ' has been updated at ' . now(env('TIME_ZONE', 'Africa/Nairobi'))->format('d-m-Y H:i:s') . " by " . request()->ip();
        if (
            $this->expiryDate != $this->oldExpiryDate ||
            $this->status != ($customer->status == 'active' ? 'yes' : 'no') ||
            $this->username != $pppoeUser->mikrotik_name ||
            $this->password != $pppoeUser->password || $this->selectedProfile != $pppoeUser->profile ||
            $this->service != $pppoeUser->service ||
            $this->remoteAddress != $pppoeUser->remote_address
        ) {
            $connect = Mikrotik::getLoginCredentials($this->mikrotikId);
            $data = [
                'new-name' => $this->username,
                'old-name' => $pppoeUser->mikrotik_name,
                'password' => $this->password,
                'profile' => $this->selectedProfile,
                'service' => $this->service,
                'remote-address' => $this->remoteAddress,
                'status' => $this->status,
                'comment' => $comment,
            ];
            $mikrotikUpdate = PppoeUser::updatePppoeUser($connect, $data);
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

        // Update PPPoE user details
        if ($pppoeUser) {
            $pppoeUser->update([
                'password' => $this->password,
                'mikrotik_name' => $this->username,
                'disabled' => $this->status == 'yes' ? 0 : 1,
                'profile' => $this->selectedProfile,
                'service' => $this->service,
                'remote_address' => $this->remoteAddress,
                'comment' => $comment,
            ]);
            session()->flash('success', 'User updated succesfully.');
            $this->dispatch('pppoe-user-activity-complete');
        } else {
            throw new ModelNotFoundException('PPPoE user not found.');
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
        $this->pppoeProfiles = Mikrotik::fetchPppoeProfiles($connect);
        if (!empty($this->pppoeProfiles)) {
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
     * Generates a random password consisting of 8 small alphanumeric characters.
     *
     * This function uses the `generateRandomSmallAlphaNumeric` helper function to generate a random password.
     * The generated password is then assigned to the `$password` property of the current component.
     *
     * @return void
     *
     * @throws \Exception If the `generateRandomSmallAlphaNumeric` function throws an exception.
     */
    public function generateRandomPassword()
    {
        $this->password = generateRandomSmallAlphaNumeric(8);
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
    #[On('close-modal')]
    public function closeModal()
    {
        $this->dispatch('cancel-update-pppoe-user');
    }
    public function checkDateTimeStatus($datetime)
    {
        $date = Carbon::parse($datetime);

        $this->status = $date->isPast() ? 'no' : 'yes';
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
    public function render()
    {
        return view('livewire.admins.isp.modals.edit-pppoe-user');
    }
}
