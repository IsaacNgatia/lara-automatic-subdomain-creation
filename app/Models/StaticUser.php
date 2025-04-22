<?php

namespace App\Models;

use App\Services\RouterosApiService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaticUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'mikrotik_name',
        'customer_id',
        'queue_type',
        'max_download_speed',
        'disabled',
        'target_address',
        'comment',
        'updated_at',
        'created_at'
    ];
    /**
     * Get the customer that owns the static customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\Customer The related customer model.
     */
    public function Customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public static function updateStaticMikrotikName(array $connect, array $data)
    {
        try {
            $routerosApiService = app(RouterosApiService::class);
            if (Mikrotik::checkRouterStatus(($connect))) {
                $staticUser = $routerosApiService->comm(
                    "/queue/simple/print",
                    array(
                        ".proplist" => ".id",
                        "?name" => $data['old-name'],
                    )
                );

                $routerosApiService->comm(
                    "/queue/simple/set",
                    array(
                        ".id" => $staticUser[0][".id"],
                        "name" => $data['new-name'],
                        "target" => $data['target-address'],
                        "max-limit" => $data['status'] == 'no' ? '1k/1k' : $data['max-limit'],
                        "limit-at" =>  $data['status'] == 'no' ? '1k/1k' : $data['max-limit'],
                        "comment" => $data['comment'],
                        "disabled" =>  'no'
                    )
                );
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }
    public static function updateStaticUser(array $connect, array $data)
    {
        try {
            $routerosApiService = app(RouterosApiService::class);
            if (Mikrotik::checkRouterStatus(($connect))) {
                $staticUser = $routerosApiService->comm(
                    "/queue/simple/print",
                    array(
                        ".proplist" => ".id",
                        "?name" => $data['name'],
                    )
                );
                if (isset($data['nat'])) {
                    $natRule = $routerosApiService->comm(
                        "/ip/firewall/nat/getall",
                        array(
                            ".proplist" => ".id",
                            "?src-address" => $data['target-address'],

                        )
                    );
                    $natResult = $routerosApiService->comm(
                        "/ip/firewall/nat/set",
                        array(
                            ".id" => $natRule[0][".id"],
                            "comment" => $data['comment'],
                            "disabled" => $data['status'] == 'yes' ? 'no' : 'yes',
                        )
                    );
                }

                if (isset($data['use-queue-types'])) {
                    $routerosApiService->comm(
                        "/queue/simple/set",
                        array(
                            ".id" => $staticUser[0][".id"],
                            "name" => $data['name'],
                            "max-limit" => '0M/0M',
                            "limit-at" => '0M/0M',
                            "queue" => $data['max-limit'] . '/' . $data['max-limit'],
                            "target" => '2.2.2.2',
                            "comment" => $data['comment'],
                            "disabled" => $data['status'] == 'yes' ? 'no' : 'yes'
                        )
                    );


                    // update filter rule
                    $filterRule = $routerosApiService->comm(
                        "/ip/firewall/filter/print",
                        array(
                            ".proplist" => ".id",
                            "?src-address" => $data['target-address'],
                        )
                    );

                    if (isset($filterRule[0][".id"])) {
                        $routerosApiService->comm(
                            "/ip/firewall/filter/set",
                            array(
                                ".id" => $filterRule[0][".id"],
                                "action" => 'accept',
                                "src-address" => $data['target-address'],
                                "chain" => 'forward',
                                "comment" => $data['comment'],
                            )
                        );
                    } else {
                        $routerosApiService->comm(
                            "/ip/firewall/filter/add",
                            array(
                                "action" => 'accept',
                                "src-address" => $data['target-address'],
                                "chain" => 'forward',
                                "comment" => $data['comment'],
                            )
                        );
                    }
                } else {

                    $routerosApiService->comm(
                        "/queue/simple/set",
                        array(
                            ".id" => $staticUser[0][".id"],
                            "name" => $data['name'],
                            "target" => $data['target-address'],
                            "max-limit" => $data['status'] == 'no' ? '1k/1k' : $data['max-limit'],
                            "limit-at" => $data['status'] == 'no' ? '1k/1k' : $data['max-limit'],
                            "comment" => $data['comment'],
                            "disabled" =>  'no'
                        )
                    );
                }
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
            return $th->getMessage();
        }
    }
    public static function deleteStaticUser(array $connect, array $data)
    {
        try {
            $routerosApiService = app(RouterosApiService::class);
            if (Mikrotik::checkRouterStatus(($connect))) {
                $staticUser = $routerosApiService->comm(
                    "/queue/simple/print",
                    array(
                        ".proplist" => ".id",
                        "?name" => $data['name'],
                    )
                );

                $routerosApiService->comm(
                    "/queue/simple/remove",
                    array(
                        ".id" => $staticUser[0][".id"],
                    )
                );
                if (isset($data['use-queue-types'])) {
                    // update filter rule

                    $filterRule = $routerosApiService->comm(
                        "/ip/firewall/filter/print",
                        array(
                            ".proplist" => ".id",
                            "?src-address" => $data['target-address'],
                        )
                    );

                    if (isset($filterRule[0][".id"])) {

                        $routerosApiService->comm(
                            "/ip/firewall/filter/remove",
                            array(
                                ".id" => $filterRule[0][".id"],
                            )
                        );
                    }
                }
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
}
