<?php

namespace App\Models;

use App\Services\RouterosApiService;
use App\Services\SmsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class HotspotCash extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'time_limit',
        'data_limit',
        'server',
        'profile',
        'is_sold',
        'mikrotik_id',
        'price',
        'comment',
        'payment_date',
        'expiry_date',
        'updated_at'
    ];
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }
    public static function addVouchers($data)
    {
        try {
            $routerosApiService = app(RouterosApiService::class);
            $connect = Mikrotik::getLoginCredentials($data['mikrotik-id']);
            $routerStatus = Mikrotik::checkRouterStatus($connect);
            if ($routerStatus == true) {
                for ($i = 0; $i < $data['length']; $i++) {
                    do {
                        $voucherName = generateRandomNumber($data['length']);
                    } while (
                        HotspotEpay::where('name', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists() ||
                        HotspotCash::where('username', $voucherName)->where('mikrotik_id', $data['mikrotik-id'])->exists()
                    );
                    $comment = 'Cash voucher ' . $voucherName . ' was created at ' . now(env('TIME_ZONE'));
                    $mikrotikData = [
                        "server" => $data['server'],
                        "name" => $voucherName,
                        "profile" => $data['profile'],
                        "limit-uptime" => $data['timelimit'],
                        "comment" => $comment,
                    ];
                    if ($data['datalimit']) {
                        $mikrotikData['"limit-bytes-out"'] = $data['datalimit'];
                    }

                    $hotspot = new HotspotCash();
                    $hotspot->username = $voucherName;
                    $hotspot->time_limit = $data['timelimit'];
                    $hotspot->data_limit = $data['datalimit'] ?? null;
                    $hotspot->server = $data['server'];
                    $hotspot->profile = $data['profile'];
                    $hotspot->is_sold = 0;
                    $hotspot->mikrotik_id = $data['mikrotik-id'];
                    $hotspot->price = $data['price'];
                    $hotspot->comment = $comment;

                    $password = null;
                    if ($data['password-status'] == 1) {
                        $password = generateRandomNumber(5);
                        $mikrotikData['password'] = $password;
                        $hotspot->password = $password;
                    }
                    $routerosApiService->comm('/ip/hotspot/user/add', $mikrotikData);

                    $hotspot->save();
                }
                return true;
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public static function markAsSold($id, $phone)
    {
        try {
            $voucher = HotspotCash::find($id);
            if (!$voucher) {
                return false;
            }
            $expiry = self::addSecondsToDatetime($voucher->time_limit);
            Transaction::create([
                'trans_id' => generateUniqueCashTransactionId(),
                'trans_amount' => $voucher->price,
                'transaction_status' => null,
                'trans_time' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s'),
                'msisdn' => $phone,
                'first_name' => 'hotspot',
                'middle_name' => 'cash',
                'last_name' => $id,
                'payment_gateway' => 'cash',
                'is_known' => 1,
                'is_partial' => 0,
                'mikrotik_id' => $voucher->mikrotik_id,
                'customer_type' => 'cash-hsp-voucher',
                'customer_id' => $id,
                'trans_type' => 'CASH',
                'valid_from' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s'),
                'valid_until' => $expiry
            ]);
            $voucher->update([
                'is_sold' => 1,
                'payment_date' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s'),
                'expiry_date' => $expiry,
            ]);
            $smsService = app(SmsService::class);
            $sms = SmsTemplate::where('subject', 'hsp_message')->first();
            if (!empty($sms)) {
                $hspData = [
                    'phone' => $phone,
                    'hsp_type' => 'cash',
                    'voucher-id' => $id
                ];
                $smsService->sendToHspClient($hspData, $sms->template, 'cash-voucher-sale');
            }

            $routerosApiService = app(RouterosApiService::class);
            $connect = Mikrotik::getLoginCredentials($voucher->mikrotik_id);
            $routerStatus = Mikrotik::checkRouterStatus($connect);
            if ($routerStatus == true) {
                $comment = 'Sold to ' . $phone . ' at ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s');
                $arrID = $routerosApiService->comm(
                    "/ip/hotspot/user/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $voucher->username,
                    )
                );
                if (empty($arrID)) {
                    return ['success' => false, 'message' => 'voucher not found in mikrotik'];
                }

                $routerosApiService->comm(
                    "/ip/hotspot/user/set",
                    array(
                        ".id" => $arrID[0][".id"],
                        "comment" => "$comment",
                    )
                );
                $voucher->update([
                    'comment' => $comment,
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return ['success' => false, 'message' => $th->getMessage()];
        }
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
