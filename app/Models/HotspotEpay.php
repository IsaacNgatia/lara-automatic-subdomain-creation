<?php

namespace App\Models;

use App\Services\RouterosApiService;
use DateTime;
use Hamcrest\Type\IsBoolean;
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
                } while (
                    HotspotEpay::where('name', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists() ||
                    HotspotCash::where('username', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists()
                );
                $comment = 'Epay voucher ' . $voucherName . ' was created at ' . now(env('TIME_ZONE'));
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
                    if (HotspotEpay::where('name', $voucherName)->exists() ||  HotspotCash::where('username', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists()) {
                        do {
                            $username = generateRandomNumber(Arr::random($array));
                        } while (HotspotEpay::where('name', $username)->exists());
                    } else {
                        $username = $voucherName;
                    }
                } else if ($data['password-status'] == 0) {
                    do {
                        $username = generateRandomNumber(Arr::random($array));
                    } while (
                        HotspotEpay::where('name', $username)->exists() ||
                        HotspotCash::where('username', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists()
                    );
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
    public static function deleteExpiredVouchers()
    {
        $timezone = config('app.timezone', 'Africa/Nairobi');
        $now = now($timezone);

        // Get all unique mikrotik IDs with expired vouchers in one query
        $mikrotikIdsWithExpiredVouchers = HotspotEpay::where('expiry_date', '<', $now)
            ->with('mikrotik')
            ->groupBy('mikrotik_id')
            ->pluck('mikrotik_id');

        foreach ($mikrotikIdsWithExpiredVouchers as $mikrotikId) {
            // Get all expired vouchers for this mikrotik
            $expiredVouchers = HotspotEpay::where('mikrotik_id', $mikrotikId)
                ->where('expiry_date', '<', $now)
                ->get();

            if ($expiredVouchers->isEmpty()) {
                continue;
            }

            // Log start of deletion process
            SystemLog::create([
                'level' => 'INFO',
                'event_type' => 'Epay Voucher Deletion',
                'message' => 'Starting the deletion of expired vouchers',
                'status' => 'success',
                'description' => 'Expired vouchers deleting for Mikrotik ID: ' . $mikrotikId,
                'file_path' => __FILE__,
                'source' => __METHOD__,
            ]);

            $routerosApiService = app(RouterosApiService::class);
            $mikrotik = $expiredVouchers->first()->mikrotik;

            try {
                $routerStatus = $routerosApiService->connect(
                    $mikrotik->ip,
                    $mikrotik->user,
                    $mikrotik->password
                );

                if (!$routerStatus) {
                    throw new \RuntimeException("Failed to connect to Mikrotik");
                }

                $deletedVouchers = [];
                $successCount = 0;

                foreach ($expiredVouchers as $voucher) {
                    // Delete user, active session, and cookie using static calls
                    $userDeleted = self::deleteMikrotikEntry($routerosApiService, "/ip/hotspot/user", "?name", $voucher->name);
                    $sessionDeleted = self::deleteMikrotikEntry($routerosApiService, "/ip/hotspot/active", "?user", $voucher->name);
                    $cookieDeleted = self::deleteMikrotikEntry($routerosApiService, "/ip/hotspot/cookie", "?user", $voucher->name);

                    if ($userDeleted || $sessionDeleted || $cookieDeleted) {
                        $deletedVouchers[] = [
                            'id' => $voucher->id,
                            'name' => $voucher->name,
                            'password' => $voucher->password ?? '',
                            'expiry_date' => $voucher->expiry_date->toDateTimeString(),
                        ];
                        $voucher->delete();
                        $successCount++;
                    }
                }

                SystemLog::create([
                    'level' => 'INFO',
                    'event_type' => 'Epay Voucher Deletion',
                    'message' => 'Expired vouchers deleted successfully',
                    'status' => 'success',
                    'description' => sprintf(
                        'Deleted %d/%d vouchers for Mikrotik ID: %s. Data: %s',
                        $successCount,
                        $expiredVouchers->count(),
                        $mikrotikId,
                        json_encode($deletedVouchers)
                    ),
                    'file_path' => __FILE__,
                    'source' => __METHOD__,
                ]);
                return true;
            } catch (\Exception $e) {
                SystemLog::create([
                    'level' => 'ERROR',
                    'event_type' => 'Epay Voucher Deletion',
                    'message' => 'Failed to delete vouchers',
                    'status' => 'failed',
                    'description' => sprintf(
                        'Error deleting vouchers for Mikrotik ID: %s. Error: %s',
                        $mikrotikId,
                        $e->getMessage()
                    ),
                    'file_path' => __FILE__,
                    'source' => __METHOD__,
                ]);
                return false;
            }
        }
    }

    private static function deleteMikrotikEntry(RouterosApiService $router, string $endpoint, string $key, string $value): bool
    {
        $entries = $router->comm("{$endpoint}/print", [$key => $value]);

        if (!empty($entries[0][".id"])) {
            $result = $router->comm("{$endpoint}/remove", [".id" => $entries[0][".id"]]);
            return $result !== false;
        }
        return false;
    }
    private static function addSecondsToDatetime(int $seconds, $datetime = null): string
    {
        // Get the timezone from the .env file or default to Africa/Nairobi
        $timezone = env('APP_TIMEZONE', 'Africa/Nairobi');

        // Create a DateTime object with the correct timezone
        $date = new \DateTime($datetime ?? 'now', new \DateTimeZone($timezone));

        // Add seconds to the datetime
        $date->modify("+{$seconds} seconds");

        return $date->format('Y-m-d H:i:s'); // Convert to string format
    }
}
