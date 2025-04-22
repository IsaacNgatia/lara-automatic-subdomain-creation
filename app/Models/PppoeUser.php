<?php

namespace App\Models;

use App\Services\RouterosApiService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PppoeUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'mikrotik_name',
        'customer_id',
        'profile',
        'password',
        'service',
        'disabled',
        'remote_address',
        'comment',
        'updated_at',
        'created_at'
    ];
    /**
     * Get the customer that owns the PPPoE user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\Customer The related customer model.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Deletes a PPPoE user from a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     * @param array $data An associative array containing the data for the PPPoE user to be deleted.
     *                    The array should have the following keys: 'name'.
     *
     * @return bool|string Returns true if the PPPoE user is successfully deleted, false if the connection fails,
     *                     or an error message if an exception occurs.
     */
    public static function deletePppoeUser(array $connect, array $data)
    {
        try {
            $routerosApiService = app(RouterosApiService::class);
            if (Mikrotik::checkRouterStatus(($connect))) {
                $pppoeUser = $routerosApiService->comm(
                    "/ppp/secret/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $data['name'],
                    )
                );

                $mikrotikReponse = $routerosApiService->comm(
                    "/ppp/secret/remove",
                    array(
                        ".id" => $pppoeUser[0][".id"],
                    )
                );
                $routerosApiService->disconnect();
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
    /**
     * Updates a PPPoE user on a Mikrotik router.
     *
     * @param array $connect An associative array containing the connection details for the Mikrotik router.
     *                       The array should have the following keys: 'ip', 'port', 'user', and 'password'.
     * @param array $data An associative array containing the data for the PPPoE user update.
     *                    The array should have the following keys: 'old-name', 'new-name', 'profile',
     *                    'service', 'comment', 'password', and 'status'.
     *
     * @return bool|string Returns true if the PPPoE user is successfully updated, false if the connection fails,
     *                     or an error message if an exception occurs.
     */
    public static function updatePppoeUser(array $connect, array $data)
    {
        $routerosApiService = app(RouterosApiService::class);
        try {
            if (self::checkRouterStatus($connect)) {
                $pppoeUser = $routerosApiService->comm(
                    "/ppp/secret/getall",
                    array(
                        ".proplist" => ".id",
                        "?name" => $data['old-name'],
                    )
                );
                $mikrotikData = array(
                    ".id" => $pppoeUser[0][".id"],
                    "name" => $data['new-name'],
                    "profile" => $data['profile'],
                    "service" => $data['service'],
                    "comment" => $data['comment'],
                    "password" => $data['password'],
                    "disabled" => $data['status'] == 'yes' ? 'no' : 'yes',
                );
                if ($data['remote-address'] && $data['remote-address'] != '') {
                    $mikrotikData['remote-address'] = $data['remote-address'];
                }

                $updateResult = $routerosApiService->comm(
                    "/ppp/secret/set",
                    $mikrotikData
                );
                $routerosApiService->disconnect();
                if (empty($updateResult)) {
                    return true;
                } else {
                    return $updateResult;
                }
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
}
