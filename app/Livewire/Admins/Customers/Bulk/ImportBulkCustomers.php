<?php

namespace App\Livewire\Admins\Customers\Bulk;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\PppoeUser;
use App\Models\Sms;
use App\Models\StaticUser;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportBulkCustomers extends Component
{
    use WithFileUploads;
    public $customersFile;
    public $transactionsFile;
    public $mikrotikFile;
    public $smsFile;
    public $walletFile;

    public function importMikrotiks()
    {
        $this->validate([
            'mikrotikFile' => 'required|file|mimes:csv,txt'
        ]);
        try {
            $path = $this->mikrotikFile->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $header =  array_shift($data);

            foreach ($data as $row) {
                $row = array_combine($header, $row);
                Mikrotik::create([
                    'name' => $row['mt_name'],
                    'user' => $row['mt_user'],
                    'password' => $row['mt_pass'],
                    'ip' => $row['mt_ip'],
                    'port' => $row['api_port'],
                    'location' => $row['mt_location'],
                    'nat' => 0,
                    'queue_types' => 0,
                    'smartolt' => 0,
                ]);
            }
            session()->flash('success', 'Mikrotiks added succefully');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function importCustomers()
    {
        $this->validate([
            'customersFile' => 'required|file|mimes:csv,txt'
        ]);
        try {

            $path = $this->customersFile->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $header =  array_shift($data);
            $batchSize = 100;
            $chunks = array_chunk($data, $batchSize);
            $password = Hash::make('1234');

            foreach ($chunks as $chunk) {

                foreach ($chunk as $row) {
                    $row = array_combine($header, $row);
                    if ($row['connectiontype'] === 'HSP') {
                        continue;
                    }
                    $connectionType = $row['connectiontype'] === 'PPP' ? 'pppoe' : ($row['connectiontype'] === 'STATIC' ? 'static' : 'rhsp');

                    $customer = [
                        'username' => $row['reference_number'],
                        'official_name' => $row['officialname'],
                        'email' => strtolower($row['email']) === 'null' || $row['email'] === '' ? null : $row['email'],
                        'reference_number' => $row['reference_number'],
                        'billing_amount' => $row['monthlybill'],
                        'billing_cycle' => $row['billing_cycle'],
                        'phone_number' => $row['mobileno'],
                        'password' => $password,
                        'connection_type' => $connectionType,
                        'expiry_date' => $row['expirydate'],
                        'comment' => $row['comment'],
                        'status' => Carbon::parse($row['expirydate'])->isPast() ? 'inactive' : 'active',
                        'location' => strtolower($row['houseno']) === 'null' || $row['houseno'] === '' ? null : $row['houseno'],
                        'mikrotik_id' => $row['mikrotikid'],
                        'parent_account' => null,
                        'installation_fee' => strtolower($row['installation_fee']) === "null" ? null :  $row['installation_fee'],
                        'service_plan_id' => null,
                        'is_parent' => 0,
                        'grace_date' => strtolower($row['grace_expiry']) === 'null' ? null : $row['grace_expiry'],
                        'last_payment_date' => strtolower($row['lastpaymentdate']) === "null" ? null :  $row['lastpaymentdate'] . ' 00:00:00',
                        'balance' => strtolower($row['balance_rem']) === "null" ? 0 : $row['balance_rem'],
                        'note' => strtolower($row['note']) === "null" ? null : $row['note'],
                        'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
                        'created_at' => $row['dtadded'] . ' 00:00:00',
                    ];
                    $customer = Customer::create($customer);

                    if ($connectionType === 'pppoe') {
                        PppoeUser::create([
                            'customer_id' => $customer->id,
                            'mikrotik_name' => $row['name'],
                            'profile' => $row['package'],
                            'service' => $row['service'],
                            'password' => $row['password'],
                            'remote_address' => $row['remoteaddress'],
                            'disabled' => Carbon::parse($row['expirydate'])->isPast() ? 1 : 0,
                            'comment' => $row['comment'],
                            'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
                            'created_at' => $row['dtadded'] . ' 00:00:00'
                        ]);
                    } else if ($connectionType === 'pppoe') {
                        StaticUser::create([
                            'customer_id' => $customer->id,
                            'mikrotik_name' => $row['name'],
                            'target_address' => $row['targetaddress'],
                            'max_download_speed' => $row['maxdownloadspeed'],
                            'disabled' => 0,
                            'comment' => $row['comment'],
                            'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
                            'created_at' => $row['dtadded'] . ' 00:00:00'
                        ]);
                    }
                }
            }
            session()->flash('success', 'Customers added succefully');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public function importTransactions()
    {
        $this->validate([
            'transactionsFile' => 'required|file|mimes:csv,txt'
        ]);
        try {
            $path = $this->transactionsFile->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $header =  array_shift($data);
            $batchSize = 100;
            $chunks = array_chunk($data, $batchSize);
            foreach ($chunks as $chunk) {
                $transactions = [];
                foreach ($chunk as $row) {
                    $row = array_combine($header, $row);
                    $transTime = isset($row['transTime']) ? Carbon::parse($row['transTime'])->format('Y-m-d H:i:s') : now('Africa/Nairobi');
                    // dd($transTime);
                    $transaction = [
                        'trans_id' => $row['transID'] ?? 'XXXXXXS',
                        'trans_amount' => isset($row['transAmount']) && $row['transAmount'] !== '' && strtolower(($row['transAmount'])) !== 'null' ? $row['transAmount'] : '0',
                        'trans_time' => $transTime,
                        'msisdn' => $row['MSISDN'],
                        'first_name' => $row['firstName'],
                        'middle_name' => strtolower($row['middleName']) === 'null' ? null : $row['middleName'],
                        'last_name' => strtolower($row['lastName']) === 'null' ? null : $row['lastName'],
                        'payment_gateway' => $row['transactionType'] === 'Pay Bill' ? 'mpesa' : 'cash',
                        'is_known' => 0,
                        'is_partial' => isset($row['billstatus']) && $row['billstatus'] === 'PARTIAL PAYMENT' ? 1 : 0,
                        'mikrotik_id' => strtolower($row['mikrotik_id']) === 'null' ? null : $row['mikrotik_id'],
                        'reference_number' => $row['billRefNumber'],
                        'short_code' => $row['businessShortCode'],
                        'trans_type' => $row['transactionType'],
                        'org_balance' => (float)$row['orgAccountBalance'] ?? null,
                        'valid_from' => !isset($row['validFrom']) || strtolower($row['validFrom']) === 'null' ? null : $row['validFrom'],
                        'valid_until' =>  strtolower($row['validUntil']) === 'null' ? null : $row['validUntil'],
                        'updated_at' => now('Africa/Nairobi'),
                        'created_at' => $transTime
                    ];
                    $customer = Customer::where('reference_number', $row['billRefNumber'])->first();
                    if (!empty($customer)) {
                        $transaction['customer_type'] = $customer->connection_type;
                        $transaction['customer_id'] = $customer->id;
                        $transaction['is_known'] = 1;
                    }
                    $transactions[] = $transaction;
                    Transaction::create($transaction);
                }
            }
            session()->flash('success', 'Transactions added succefully');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public function importSms()
    {
        $this->validate([
            'smsFile' => 'required|file|mimes:csv,txt'
        ]);
        try {
            $path = $this->smsFile->getRealPath();
            $data = array_map('str_getcsv', file($path));
            $header =  array_map('trim', array_shift($data));
            $batchSize = 100;
            $chunks = array_chunk($data, $batchSize);

            foreach ($chunks as $chunk) {
                foreach ($chunk as $row) {
                    $row = array_combine($header, $row);

                    $smsData = [
                        'is_sent' => strtolower($row['response_description']) === 'success' || strtolower($row['response_description']) === 'delivered' ? 1 : 0,
                        'recipient' => $this->convertToLocalFormat($row['mobile']),
                        'message' => $row['message'],
                        'message_id' => strtolower($row['message_id']) === 'null' ? null : $row['message_id'],
                        'subject' => $row['sent_from'],
                        'created_at' => $row['created_at'],
                        'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
                    ];
                    $customer = Customer::where('phone_number', $this->convertToLocalFormat($row['mobile']))->first();
                    if (!empty($customer)) {
                        $smsData['customer_id'] = $customer->id;
                    }
                    Sms::create($smsData);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    function convertToLocalFormat(string $phone): string
    {
        // Remove any non-digit characters
        $phone = preg_replace('/\D/', '', $phone);

        // If it starts with 254 and followed by 9 digits
        if (preg_match('/^254(\d{9})$/', $phone, $matches)) {
            return '0' . $matches[1];
        }

        // If it’s 9 digits and starts with 7, add the leading zero
        if (preg_match('/^7\d{8}$/', $phone)) {
            return '0' . $phone;
        }

        // If it already starts with 0 and is 10 digits, assume it's valid
        if (preg_match('/^0\d{9}$/', $phone)) {
            return $phone;
        }

        // Return as-is for anything else
        return $phone;
    }


    public function render()
    {
        return view('livewire.admins.customers.bulk.import-bulk-customers');
    }
}
