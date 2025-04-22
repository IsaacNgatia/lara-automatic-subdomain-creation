<?php

namespace App\Models;

use App\Services\RouterosApiService;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;


class HotspotEpay extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'password',
        'time_limit',
        'data_limit',
        'epay_package_id',
        'price',
        'is_sold',
        'logged_in',
        'mikrotik_id',
        'comment',
        'payment_date',
        'expiry_date',
    ];
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }
    public function epayPackage(): BelongsTo
    {
        return $this->belongsTo(EpayPackage::class);
    }
    /**
     * This function generates a hotspot voucher on a Mikrotik router and creates an entry in the HotspotEpay model.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     * @param array $data An associative array containing the voucher details and package information.
     *
     * @return array An associative array containing the success status, voucher details, and error message if applicable.
     *
     * @throws \Throwable If an exception occurs during the process.
     */
    public static function generateHotspotVoucher($connect, $data)
    {
        try {
            $ipWithPort = $connect['port'] ? $connect['ip'] . ':' . $connect['port'] : $connect['ip'] . ':8728';
            $routerosApiService = app(RouterosApiService::class);
            $routerStatus = $routerosApiService->connect($ipWithPort, $connect['user'], $connect['password']);
            if ($routerStatus == true) {
                $array = [4, 5, 6, 7];
                do {
                    $voucherName = generateRandomNumber($data['length']);
                } while (HotspotEpay::where('name', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists());
                $comment = 'Voucher ' . $voucherName . ' was created at ' . now(env('TIME_ZONE'));
                $mikrotikData = [
                    "server" => $data['server'],
                    "name" => $voucherName,
                    "profile" => $data['profile'],
                    "limit-uptime" => $data['timelimit'],
                    "limit-bytes-out" => $data['datalimit'],
                    "comment" => $comment,
                ];

                $password = null;
                if ($data['password-status'] == 1) {
                    $password = generateRandomNumber(5);
                    $mikrotikData['password'] = $password;
                    if (HotspotEpay::where('name', $voucherName)->exists()) {
                        do {
                            $username = generateRandomNumber(Arr::random($array));
                        } while (HotspotEpay::where('name', $username)->exists());
                    } else {
                        $username = $voucherName;
                    }
                } else if ($data['password-status'] == 0) {
                    do {
                        $username = generateRandomNumber(Arr::random($array));
                    } while (HotspotEpay::where('name', $username)->exists());
                }
                $routerosApiService->comm('/ip/hotspot/user/add', $mikrotikData);
                $expiry = isset($data['set-expiry'])  && $data['set-expiry'] == false ? null : self::addSecondsToDatetime($data['timelimit'], now(env('TIME_ZONE')));
                $createEntry = HotspotEpay::create([
                    'name' => $voucherName,
                    'password' => $password,
                    'time_limit' => $data['timelimit'],
                    'data_limit' => $data['datalimit'],
                    'is_sold' => isset($data['set-expiry'])  && $data['set-expiry'] == false ? 0 : 1,
                    'epay_package_id' => $data['package-id'],
                    'mikrotik_id' => $data['mikrotik-id'],
                    'price' => $data['price'],
                    'comment' => $comment,
                    'payment_date' => now(env('APP_TIMEZONE')),
                    'expiry_date' => $expiry,
                ]);
                return ['success' => true, 'voucher' => ['username' => $voucherName, 'password' => $password, 'id' => $createEntry, 'expiry' => $expiry]];
            } else {
                return ['success' => false, 'message' => 'Router is offline'];
            }
        } catch (\Throwable $th) {
            return ['success' => false, 'message' => $th->getMessage()];
        }
    }
    private static function addSecondsToDatetime(int $seconds, $datetime = null): string
    {
        // Get the timezone from the .env file or default to UTC
        $timezone = env('APP_TIMEZONE', 'UTC');

        // Create a DateTime object with the correct timezone
        $date = new \DateTime($datetime ?? 'now', new \DateTimeZone($timezone));

        // Add seconds to the datetime
        $date->modify("+{$seconds} seconds");

        return $date->format('Y-m-d H:i:s'); // Convert to string format
    }
}
