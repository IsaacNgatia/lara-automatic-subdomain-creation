<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\RouterosApiService;
use App\Models\Customer;
use App\Services\OvpnService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class Mikrotik extends Model
{
    use HasFactory;
    // Define the attributes that are mass assignable
    protected $fillable = [
        'name',
        'user',
        'password',
        'ip',
        'port',
        'location',
        'recipient',
        'nat',
        'queue_types',
        'smartolt'
    ];
    /**
     * Get the customers associated with the Mikrotik.
     *
     * This function retrieves all customers that are associated with the current Mikrotik instance.
     * It utilizes Laravel's Eloquent ORM to define a one-to-many relationship with the 'Customer' model.
     *
     * @return HasMany A collection of 'Customer' models that are associated with the current Mikrotik instance.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);  // Define a one-to-many relationship with the 'Customer' model
    }
    /**
     * Get the packages associated with the Mikrotik.
     *
     * This function retrieves all packages that are associated with the current Mikrotik instance.
     * It utilizes Laravel's Eloquent ORM to define a one-to-many relationship with the 'Package' model.
     *
     * @return HasMany A collection of 'Package' models that are associated with the current Mikrotik instance.
     */
    public function servicePlan(): HasMany
    {
        return $this->hasMany(ServicePlan::class);  // Define a one-to-many relationship with the 'Customer' model
    }
    /**
     * Retrieves the login credentials for a Mikrotik router.
     *
     * @param int $id The ID of the Mikrotik router.
     *
     * @return array|string Returns an associative array containing the login credentials
     *                      if successful, or an error message if an exception occurs.
     *                      The array will have the keys 'ip', 'port', 'user', and 'password'.
     *
     * @throws \Exception If an exception occurs while retrieving the login credentials.
     */
    public static function getLoginCredentials($id)
    {
        try {
            $mikrotik = self::find($id);
            return [
                'ip' => $mikrotik->ip,
                'port' => $mikrotik->port,
                'user' => $mikrotik->user,
                'password' => $mikrotik->password,
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Checks the status of a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     *
     * @return bool Returns true if the connection to the Mikrotik router is successful, false otherwise.
     *
     * @throws \Exception If an exception occurs during the communication with the Mikrotik router.
     */
    public static function checkRouterStatus(array $connect)
    {
        $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
        try {
            $routerosApiService = app(RouterosApiService::class);
            return $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * Creates a new static user on a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     * @param array $userData An associative array containing the user data for the new static user.
     *                        The array should have the following keys: 'username', 'target_address',
     *                        'max_limit', and 'comment'.
     *
     * @return bool|string Returns true if the static user is successfully created,
     *                      false if the connection to the Mikrotik router fails,
     *                      or an error message if an exception occurs.
     */
    public static function createStaticUser(array $connect, array $userData)
    {
        try {
            $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
            $routerosApiService = app(RouterosApiService::class);
            $routerStatus = $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
            if ($routerStatus == true) {
                $staticUser = $routerosApiService->comm(
                    "/queue/simple/add",
                    array(
                        "name" => $userData['username'],
                        "target" => $userData['target_address'],
                        "max-limit" => $userData['max_limit'],
                        "limit-at" => $userData['max_limit'],
                        "comment" => $userData['comment']
                    )
                );
                return true;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Creates a new PPPoE user on a Mikrotik router.
     *
     * This function connects to a Mikrotik router using the provided credentials,
     * and then adds a new PPPoE user using the provided user data.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     * @param array $userData An associative array containing the user data for the new PPPoE user.
     *                        The array should have the following keys: 'name', 'password', 'service', 'profile', and 'comment'.
     *
     * @return bool|string Returns true if the PPPoE user is successfully created,
     *                      false if the connection to the Mikrotik router fails,
     *                      or an error message if an exception occurs.
     */
    public static function createPppoeUser(array $connect, array $userData)
    {
        try {
            $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
            $routerosApiService = app(RouterosApiService::class);
            $routerStatus = $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
            if ($routerStatus == true) {
                $pppoeUser = $routerosApiService->comm('/ppp/secret/add', [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'service' => $userData['service'],
                    'profile' => $userData['profile'],
                    'comment' => $userData['comment']
                ]);
                return $pppoeUser && !empty($pppoeUser);
                // if($pppoeUser['!trap'][0]['message']){
                //     return $pppoeUser['!trap'][0]['message'];
                // } else{
                //     return $pppoeUser;
                // }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Creates a new set of E-Pay vouchers on a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     * @param array $data An associative array containing the data for the new E-Pay vouchers.
     *                    The array should have the following keys: 'mikrotik-id', 'server', 'profile',
     *                    'length', 'quantity', 'timelimit', 'datalimit', 'password-status', 'price',
     *                    and 'packageName'.
     *
     * @return bool|string Returns true if the E-Pay vouchers are successfully created,
     *                      false if the connection to the Mikrotik router fails,
     *                      or an error message if an exception occurs.
     */
    public static function createEpayVouchers(array $connect, array $data)
    {
        try {
            $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
            $routerosApiService = app(RouterosApiService::class);
            $routerStatus = $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
            if ($routerStatus == true) {
                $array = [4, 5, 6, 7];
                for ($i = 1; $i <= $data['quantity']; $i++) {
                    do {
                        $voucherName = generateRandomNumber($data['length']);
                    } while (HotspotEpay::where('name', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists());
                    $comment = 'Voucher ' . $voucherName . ' was created at ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
                    $mikrotikData = [
                        "server" => $data['server'],
                        "name" => $voucherName,
                        "profile" => $data['profile'],
                        "limit-uptime" => $data['timelimit'],
                        "limit-bytes-out" => $data['datalimit'],
                        "comment" => $comment,
                    ];
                    if ($data['password-status'] == 1) {
                        $password = generateRandomNumber(5);
                        $mikrotikData['password'] = $password;
                        if (HotspotEpay::where('reference_number', $voucherName)->exists()) {
                            do {
                                $referenceNumber = generateRandomNumber(Arr::random($array));
                            } while (HotspotEpay::where('reference_number', $referenceNumber)->exists());
                        } else {
                            $referenceNumber = $voucherName;
                        }
                    } else if ($data['password-status'] == 0) {
                        do {
                            $referenceNumber = generateRandomNumber(Arr::random($array));
                        } while (HotspotEpay::where('reference_number', $referenceNumber)->exists());
                    }
                    $routerosApiService->comm('/ip/hotspot/user/add', $mikrotikData);
                    HotspotEpay::create([
                        'name' => $voucherName,
                        'password' => $password,
                        'reference_number' => $referenceNumber,
                        'time_limit' => $data['timelimit'],
                        'data_limit' => $data['datalimit'],
                        'server' => $data['server'],
                        'profile' => $data['profile'],
                        'package_name' => $data['packageName'],
                        'is_sold' => 0,
                        'mikrotik_id' => '1',
                        'price' => $data['price'],
                        'comment' => $comment,
                    ]);
                }
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    /**
     * Fetches all PPPoE profiles from a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     *
     * @return array|bool Returns an array of PPPoE profiles if the connection is successful,
     *                     or false if the connection fails.
     *
     * @throws \Exception If an exception occurs during the communication with the Mikrotik router.
     */
    public static function fetchPppoeProfiles(array $connect)
    {
        try {
            $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
            $routerosApiService = app(RouterosApiService::class);
            $routerStatus = $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
            if ($routerStatus == true) {
                $pppoeProfiles = $routerosApiService->comm('/ppp/profile/getall');
                $routerosApiService->disconnect();
                return $pppoeProfiles;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    /**
     * Fetches all Hotspot Servers and User Profiles from a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     *
     * @return array|bool Returns an associative array containing 'servers' and 'user-profiles' if the connection is successful,
     *                     or false if the connection fails.
     *                     'servers' contains the list of Hotspot servers.
     *                     'user-profiles' contains the list of Hotspot user profiles.
     *
     * @throws \Exception If an exception occurs during the communication with the Mikrotik router.
     */
    public static function fetchHspDetails(array $connect)
    {
        try {
            $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
            $routerosApiService = app(RouterosApiService::class);
            $routerStatus = $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
            if ($routerStatus == true) {
                $servers = $routerosApiService->comm('/ip/hotspot/print');
                $userProfiles = $routerosApiService->comm('/ip/hotspot/user/profile/print');
                $routerosApiService->disconnect();
                return ['servers' => $servers, 'user-profiles' => $userProfiles];
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            // throw $th;
            return false;
        }
    }
    /**
     * Purchases a Hotspot voucher on a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     * @param array $data An associative array containing the data for the Hotspot voucher purchase.
     *                    The array should have the following keys: 'voucher' and 'comment'.
     *
     * @return bool Returns true if the Hotspot voucher is successfully purchased, false otherwise.
     *
     * @throws \Exception If an exception occurs during the communication with the Mikrotik router.
     */
    public static function purchaseHspVoucher(array $connect, array $data)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            if (self::checkRouterStatus($connect)) {
                $voucherId = $routerosApiService->comm(
                    "/ip/hotspot/user/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $data['voucher'],
                    )
                );

                $routerosApiService->comm(
                    "/ip/hotspot/user/set",
                    array(
                        ".id" => $voucherId[0][".id"],
                        "disabled" => 'no',
                        "comment" => $data['comment']
                    )
                );
                $routerosApiService->disconnect();
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function raisePppoeCustomer($customerId)
    {
        $routerosApiService = app(RouterosApiService::class);
        $customer = Customer::find($customerId);
        $pppoeUser = $customer->pppoeUser;
        if (self::checkRouterStatus(self::getLoginCredentials($customer->mikrotik_id))) {
            $comment = $pppoeUser->mikrotik_name . ' has paid was raised on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
            $pppId = $routerosApiService->comm(
                "/ppp/secret/getall",
                array(
                    ".proplist" => ".id",
                    "?name" => $pppoeUser->mikrotik_name,
                )
            );

            $routerosApiService->comm(
                "/ppp/secret/set",
                array(
                    ".id" => $pppId[0][".id"],
                    "comment" => $comment,
                    "profile" => $pppoeUser->profile,
                    "disabled" => 'no'
                )
            );

            $routerosApiService->disconnect();

            $pppoeUser->update([
                'disabled' => false,
                'comment' => $comment,
                'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))
            ]);
            $customer->update(['status' => 'active']);
            return true;
        } else {
            return false;
        }
    }
    public static function raiseStaticCustomer($customerId)
    {
        $routerosApiService = app(RouterosApiService::class);
        $customer = Customer::find($customerId);
        $staticUser = $customer->staticUser;

        if (self::checkRouterStatus(self::getLoginCredentials($customer->mikrotik_id))) {
            $comment = $staticUser->mikrotik_name . '  has paid was raised on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));

            $mikrotik = $customer->mikrotik;
            $arrID = $routerosApiService->comm(
                "/queue/simple/print",
                array(
                    ".proplist" => ".id",
                    "?name" => $staticUser->mikrotik_name,
                )
            );
            if ($mikrotik->nat == 1) {
                $natId = $routerosApiService->comm(
                    "/ip/firewall/nat/getall",
                    array(
                        ".proplist" => ".id",
                        "?src-address" => $staticUser->target_address,

                    )
                );
                $natResult = $routerosApiService->comm(
                    "/ip/firewall/nat/set",
                    array(
                        ".id" => $natId[0][".id"],
                        "comment" => $comment,
                        "disabled" => 'no',
                    )
                );
            }

            if ($mikrotik->queue_types != 1) {
                $routerosApiService->comm(
                    "/queue/simple/set",
                    array(
                        ".id" => $arrID[0][".id"],
                        "name" => $staticUser->mikrotik_name,
                        "max-limit" => $staticUser->max_download_speed,
                        "limit-at" => $staticUser->max_download_speed,
                        "comment" => $comment,
                        "disabled" => 'no'
                    )
                );
            } else {
                $routerosApiService->comm(
                    "/queue/simple/set",
                    array(
                        ".id" => $arrID[0][".id"],
                        "name" => $staticUser->mikrotik_name,
                        "max-limit" => '0M/0M',
                        "limit-at" => '0M/0M',
                        "queue" => $staticUser->max_download_speed . '/' . $staticUser->max_download_speed,
                        "comment" => $comment,
                        "disabled" => 'no'
                    )
                );


                // update filter rule
                $filterId = $routerosApiService->comm(
                    "/ip/firewall/filter/print",
                    array(
                        ".proplist" => ".id",
                        "?src-address" => $staticUser->target_address,
                    )
                );

                if (isset($filterId[0][".id"])) {
                    $routerosApiService->comm(
                        "/ip/firewall/filter/set",
                        array(
                            ".id" => $filterId[0][".id"],
                            "action" => 'accept',
                            "src-address" => $staticUser->target_address,
                            "chain" => 'forward',
                            "comment" => $comment
                        )
                    );
                } else {
                    $routerosApiService->comm(
                        "/ip/firewall/filter/add",
                        array(
                            "action" => 'accept',
                            "src-address" => $staticUser->target_address,
                            "chain" => 'forward',
                            "comment" => $comment
                        )
                    );
                }
            }
            $routerosApiService->disconnect();

            $staticUser->update(['comment' => $comment, 'disabled' => 0, 'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s')]);
            $customer->update(['status' => 'active']);
            return true;
        } else {
            return false;
        }
    }

    public static function raiseHotspotCustomer($customerId)
    {

        $routerosApiService = app(RouterosApiService::class);
        $customer = Customer::find($customerId);
        $recurringHotspot = $customer->recurringHotspotUser;

        if (self::checkRouterStatus(self::getLoginCredentials($customer->mikrotik_id))) {
            $comment = $recurringHotspot->mikrotik_name . ' has paid was raised on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
            $arrID = $routerosApiService->comm(
                "/ip/hotspot/user/getall",
                array(
                    ".proplist" => ".id",
                    "?name" => $recurringHotspot->mikrotik_name,
                )
            );

            $routerosApiService->comm(
                "/ip/hotspot/user/set",
                array(
                    ".id" => $arrID[0][".id"],
                    "profile" => $recurringHotspot->profile,
                    "disabled" => 'no',
                    "comment" => $comment
                )
            );

            $routerosApiService->disconnect();

            return true;
        } else {
            return false;
        }
    }

    public static function updateUserAfterPayment(array $connect, array $data)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            if (self::checkRouterStatus($connect)) {
                if ($data['userType'] == 'pppoe') {
                    $pppoeUser = PppoeUser::where('customer_id', $data['customer_id'])->first();
                    $comment = $pppoeUser->mikrotik_name . ' has paid ' . $data['amount'] . ' on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
                    $pppId = $routerosApiService->comm(
                        "/ppp/secret/getall",
                        array(
                            ".proplist" => ".id",
                            "?name" => $pppoeUser->mikrotik_name,
                        )
                    );

                    $routerosApiService->comm(
                        "/ppp/secret/set",
                        array(
                            ".id" => $pppId[0][".id"],
                            "comment" => $comment,
                            "profile" => $pppoeUser->profile,
                            "disabled" => 'no'
                        )
                    );

                    $routerosApiService->disconnect();
                    $pppoeUser->update([
                        'disabled' => false,
                        'comment' => $comment,
                        'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))
                    ]);
                    return true;
                }
                if ($data['userType'] == 'static') {
                    $staticUser = StaticUser::where('customer_id', $data['customer_id'])->first();
                    $comment = $staticUser->mikrotik_name . ' has paid ' . $data['amount'] . ' on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
                    $customer = Customer::find($data['customer_id']);
                    $mikrotik = $customer->mikrotik;
                    $arrID = $routerosApiService->comm(
                        "/queue/simple/print",
                        array(
                            ".proplist" => ".id",
                            "?name" => $staticUser->mikrotik_name,
                        )
                    );
                    if ($mikrotik->nat == 1) {
                        $natId = $routerosApiService->comm(
                            "/ip/firewall/nat/getall",
                            array(
                                ".proplist" => ".id",
                                "?src-address" => $staticUser->target_address,

                            )
                        );
                        $natResult = $routerosApiService->comm(
                            "/ip/firewall/nat/set",
                            array(
                                ".id" => $natId[0][".id"],
                                "comment" => $comment,
                                "disabled" => 'no',
                            )
                        );
                    }

                    if ($mikrotik->queue_types != 1) {
                        $routerosApiService->comm(
                            "/queue/simple/set",
                            array(
                                ".id" => $arrID[0][".id"],
                                "name" => $staticUser->mikrotik_name,
                                "max-limit" => $staticUser->max_download_speed,
                                "limit-at" => $staticUser->max_download_speed,
                                "comment" => $comment,
                                "disabled" => 'no'
                            )
                        );
                    } else {
                        $routerosApiService->comm(
                            "/queue/simple/set",
                            array(
                                ".id" => $arrID[0][".id"],
                                "name" => $staticUser->mikrotik_name,
                                "max-limit" => '0M/0M',
                                "limit-at" => '0M/0M',
                                "queue" => $staticUser->max_download_speed . '/' . $staticUser->max_download_speed,
                                "comment" => $comment,
                                "disabled" => 'no'
                            )
                        );


                        // update filter rule
                        $filterId = $routerosApiService->comm(
                            "/ip/firewall/filter/print",
                            array(
                                ".proplist" => ".id",
                                "?src-address" => $staticUser->target_address,
                            )
                        );

                        if (isset($filterId[0][".id"])) {
                            $routerosApiService->comm(
                                "/ip/firewall/filter/set",
                                array(
                                    ".id" => $filterId[0][".id"],
                                    "action" => 'accept',
                                    "src-address" => $staticUser->target_address,
                                    "chain" => 'forward',
                                    "comment" => $comment
                                )
                            );
                        } else {
                            $routerosApiService->comm(
                                "/ip/firewall/filter/add",
                                array(
                                    "action" => 'accept',
                                    "src-address" => $staticUser->target_address,
                                    "chain" => 'forward',
                                    "comment" => $comment
                                )
                            );
                        }
                    }
                    $routerosApiService->disconnect();
                    $staticUser->update(['comment' => $comment, 'disabled' => 0, 'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s')]);
                    return true;
                }
                if ($data['userType'] == 'rhsp') {
                    $recurringHotspot = HotspotRecurring::where('customer_id', '=', $data['customer_id'])->first();
                    $comment = $recurringHotspot->mikrotik_name . ' has paid ' . $data['amount'] . ' on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
                    $arrID = $routerosApiService->comm(
                        "/ip/hotspot/user/getall",
                        array(
                            ".proplist" => ".id",
                            "?name" => $recurringHotspot->mikrotik_name,
                        )
                    );

                    $routerosApiService->comm(
                        "/ip/hotspot/user/set",
                        array(
                            ".id" => $arrID[0][".id"],
                            "profile" => $recurringHotspot->profile,
                            "disabled" => 'no',
                            "comment" => $comment
                        )
                    );

                    $routerosApiService->disconnect();
                    return true;
                }
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function createPppoeDisconnectProfile($mikrotikId)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            $connect = self::getLoginCredentials($mikrotikId);
            if (self::checkRouterStatus($connect)) {
                $name = 'Disconnect';
                $disconnectProfiles = $routerosApiService->comm('/ppp/profile/print', array(
                    ".proplist" => ".id",
                    "?name" => $name,
                ));
                // $hasDisconnectProfile = collect($disconnectProfiles)->contains('name', $name);
                if (empty($disconnectProfiles)) {
                    $comment = "PPP Profile with name " . $name . " was created on : " . now(env('APP_TIMEZONE', 'Africa/Nairobi')) . " by " . $_SERVER['REMOTE_ADDR'];

                    $routerosApiService->comm(
                        "/ppp/profile/add",
                        array(
                            "name" => $name,
                            "rate-limit" => '1k/1k',
                            "comment" => $comment,
                        )
                    );

                    $routerosApiService->disconnect();
                }
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function createHspDisconnectProfile($mikrotikId)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            $connect = self::getLoginCredentials($mikrotikId);
            if (self::checkRouterStatus($connect)) {
                $name = 'Disconnect';
                $disconnectProfiles = $routerosApiService->comm('/ip/hotspot/user/profile/print', array(
                    ".proplist" => ".id",
                    "?name" => $name,
                ));
                // $hasDisconnectProfile = collect($disconnectProfiles)->contains('name', $name);
                if (empty($disconnectProfiles)) {
                    $comment = "Hotspot Profile with name " . $name . " was created on : " . now(env('APP_TIMEZONE', 'Africa/Nairobi')) . " by " . $_SERVER['REMOTE_ADDR'];

                    $routerosApiService->comm(
                        "/ip/hotspot/user/profile/add",
                        array(
                            "name" => $name,
                            "rate-limit" => '1k/1k',
                            "comment" => $comment,
                        )
                    );

                    $routerosApiService->disconnect();
                }
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }
    public static function downStaticCustomer($customerId)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            $customer = Customer::find($customerId);
            $staticUser = $customer->staticUser;
            $mikrotik = $customer->mikrotik;
            $connect = self::getLoginCredentials($customer->mikrotik_id);
            if (self::checkRouterStatus($connect)) {
                $comment = $staticUser->mikrotik_name . ' has been DOWNED on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
                $arrID = $routerosApiService->comm(
                    "/queue/simple/print",
                    array(
                        ".proplist" => ".id",
                        "?name" => $staticUser->mikrotik_name,
                    )
                );

                if ($mikrotik->queue_types == 0) {
                    $routerosApiService->comm(
                        "/queue/simple/set",
                        array(
                            ".id" => $arrID[0][".id"],
                            "comment" => $comment,
                            "max-limit" => '1k/1k',
                            "limit-at" => '1k/1k',
                            "disabled" => 'no'
                        )
                    );
                    if ($mikrotik->nat) {
                        $natId = $routerosApiService->comm(
                            "/ip/firewall/nat/getall",
                            array(
                                ".proplist" => ".id",
                                "?src-address" => $staticUser->target_address,
                            )
                        );
                        $natResult = $routerosApiService->comm(
                            "/ip/firewall/nat/set",
                            array(
                                ".id" => $natId[0][".id"],
                                "comment" => $comment,
                                "disabled" => 'yes',
                            )
                        );
                    }
                } else {
                    $routerosApiService->comm(
                        "/queue/simple/set",
                        array(
                            ".id" => $arrID[0][".id"],
                            "comment" => $comment,
                            "max-limit" => '1k/1k',
                            "limit-at" => '1k/1k',
                            "queue" => 'DISCONNECT/DISCONNECT',
                            "disabled" => 'no'
                        )
                    );
                    if ($mikrotik->nat) {
                        $natId = $routerosApiService->comm(
                            "/ip/firewall/nat/getall",
                            array(
                                ".proplist" => ".id",
                                "?src-address" => $staticUser->target_address,
                            )
                        );
                        $natResult = $routerosApiService->comm(
                            "/ip/firewall/nat/set",
                            array(
                                ".id" => $natId[0][".id"],
                                "comment" => $comment,
                                "disabled" => 'yes',
                            )
                        );
                    }

                    // update filter rule
                    $filID = $routerosApiService->comm(
                        "/ip/firewall/filter/print",
                        array(
                            ".proplist" => ".id",
                            "?src-address" => $staticUser->target_address,
                        )
                    );

                    if (isset($filID[0][".id"])) {
                        $routerosApiService->comm(
                            "/ip/firewall/filter/set",
                            array(
                                ".id" => $filID[0][".id"],
                                "action" => 'drop',
                                "src-address" => $staticUser->target_address,
                                "chain" => 'forward',
                                "comment" => $comment
                            )
                        );
                    } else {
                        $routerosApiService->comm(
                            "/ip/firewall/filter/add",
                            array(
                                "action" => 'drop',
                                "src-address" => $staticUser->target_address,
                                "chain" => 'forward',
                                "comment" => $comment
                            )
                        );
                    }
                }

                $routerosApiService->disconnect();
                $staticUser->update(['comment' => $comment, 'disabled' => 1, 'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s')]);
                $customer->update(['status' => 'inactive']);
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
    public static function downPppoeCustomer($customerId)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            $customer = Customer::find($customerId);
            $pppoeUser = $customer->pppoeUser;
            $mikrotik = $customer->mikrotik;
            $connect = self::getLoginCredentials($customer->mikrotik_id);
            if (self::checkRouterStatus($connect)) {
                self::createPppoeDisconnectProfile($customer->mikrotik_id);
                $comment = $pppoeUser->mikrotik_name . ' has been DOWNED on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
                $secret = $routerosApiService->comm(
                    "/ppp/secret/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $pppoeUser->mikrotik_name,
                    )
                );

                if (!empty($secret)) {
                    $routerosApiService->comm(
                        "/ppp/secret/set",
                        array(
                            ".id" => $secret[0][".id"],
                            "disabled" => 'yes',
                            "profile" => 'Disconnect',
                            "comment" => $comment
                        )
                    );
                }
                $userIsActive = $routerosApiService->comm(
                    "/ppp/active/print",
                    array(
                        "?name" => $pppoeUser->mikrotik_name,
                    )
                );
                if (!empty($userIsActive)) {
                    $routerosApiService->comm(
                        "/ppp/active/remove",
                        array(
                            ".id" => $userIsActive[0][".id"],
                        )
                    );
                }

                $routerosApiService->disconnect();
                $result = $pppoeUser->update(['comment' => $comment, 'disabled' => 1, 'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s')]);
                $customer->update(['status' => 'inactive']);
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
    public static function downHotspotCustomer($customerId)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            $customer = Customer::find($customerId);
            $recurringHspUser = $customer->recurringHotspotUser;
            $mikrotik = $customer->mikrotik;
            $comment = $recurringHspUser->mikrotik_name . ' has been DOWNED on ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'));
            $connect = self::getLoginCredentials($customer->mikrotik_id);
            if (self::checkRouterStatus($connect)) {
                $arrID = $routerosApiService->comm(
                    "/ip/hotspot/user/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $recurringHspUser->mikrotik_name,
                    )
                );

                $routerosApiService->comm(
                    "/ip/hotspot/user/set",
                    array(
                        ".id" => $arrID[0][".id"],
                        "profile" => "Disconnect",
                        "disabled" => 'no',
                        "comment" => $comment
                    )
                );

                $routerosApiService->disconnect();
                $recurringHspUser->update(['comment' => $comment, 'disabled' => 1, 'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s')]);
                $customer->update(['status' => 'inactive']);
                return true;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public static function deleteHotspotVoucher($username, $mikrotik_id)
    {
        try {
            $routerosApiService = app(RouterosApiService::class);
            $connect = self::getLoginCredentials($mikrotik_id);
            if (self::checkRouterStatus($connect)) {
                $voucherId = $routerosApiService->comm(
                    "/ip/hotspot/user/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $username,
                    )
                );
                $routerosApiService->comm(
                    "/ip/hotspot/user/remove",
                    array(
                        ".id" => $voucherId[0][".id"],
                    )
                );
                return true;
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public static function createOvpnFiles($routerName)
    {
        try {
            // Initialize the service
            $ovpnService = new OvpnService();
            $currentYear = now(env('APP_TIMEZONE', 'Africa/Nairobi'))->year;
            $randomPassword = self::generateRandomPassword();
            $username = 'ISPKenya' . $currentYear;

            // Generate and save OpenVPN files
            $filesCreated = $ovpnService->setupFiles($routerName);
            Log::info('New Files Created:', ['creating-files' => $filesCreated]);
            if ($filesCreated['success'] === true) {



                // Update OpenVPN script with credentials
                $rscFileCreated = $ovpnService->updateOvpnScript($username, $randomPassword, $routerName);
                Log::info('Ovpn File edited:', ['rsc-file-edited' => $rscFileCreated]);

                $mikrotik = Mikrotik::firstOrCreate(
                    ['name' => $routerName], // Check if a Mikrotik with this name exists
                    [
                        'user' => $username,
                        'password' => $randomPassword, // Store password securely
                        'ip' => '47.237.106.106',
                        'port' => $filesCreated['api_port'],
                        'location' => 'Kenya',
                        'year' => $currentYear,
                    ]
                );
                Log::info('Mikrotik added to the database:', ['add-mikrotik-to-db' => $mikrotik]);

                return [
                    'files_created' => $filesCreated,
                    'rsc_file_created' => $rscFileCreated,
                    'mikrotik_added' => $mikrotik
                ];
            } else {
                return Log::info('Files not created:', ['error-message' => $filesCreated['message']]);
            }
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private static function generateRandomPassword($length = 10)
    {
        return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, $length);
    }
}
