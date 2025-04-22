<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Mikrotik;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function disconnectCustomers()
    {
        try {
            $timezone = new DateTimeZone(env('TIME_ZONE', 'Africa/Nairobi'));
            $currentDate = new DateTime('now', $timezone);
            $currentDate->setTime(23, 59, 59);

            $formattedDate = $currentDate->format('Y-m-d H:i:s');
            $expiredCustomers = Customer::expiredButActive($formattedDate);

            $staticUserNo = 0;
            $pppoeUserNo = 0;
            $rhspUserNo = 0;
            $pppoeMikrotikIds = collect($expiredCustomers)
                ->filter(function ($customer) {
                    return $customer->connection_type === 'pppoe';
                })
                ->pluck('mikrotik_id')
                ->unique()
                ->values()
                ->all();
            if (!empty($pppoeMikrotikIds)) {
                foreach ($pppoeMikrotikIds as $mikrotikId) {
                    $pppoeDisconnectProfile = Mikrotik::createPppoeDisconnectProfile($mikrotikId);
                }
            }
            $rhspMikrotikIds = collect($expiredCustomers)
                ->filter(function ($customer) {
                    return $customer->connection_type === 'rhsp';
                })
                ->pluck('mikrotik_id')
                ->unique()
                ->values()
                ->all();
            if (!empty($rhspMikrotikIds)) {
                foreach ($rhspMikrotikIds as $mikrotikId) {
                    $rhspDisconnectProfile = Mikrotik::createHspDisconnectProfile($mikrotikId);
                }
            }
            for ($i = 0; $i < sizeof($expiredCustomers); $i++) {
                if ($expiredCustomers[$i]->connection_type == 'static') {
                    $staticCustomer = Mikrotik::downStaticCustomer($expiredCustomers[$i]->id);
                    if ($staticCustomer) {
                        $staticUserNo++;
                    }
                } else if ($expiredCustomers[$i]->connection_type == 'pppoe') {
                    $pppoeCustomer = Mikrotik::downPppoeCustomer($expiredCustomers[$i]->id);
                    if ($pppoeCustomer) {
                        $pppoeUserNo++;
                    }
                } else if ($expiredCustomers[$i]->connection_type == 'rhsp') {
                    $rhspCustomer = Mikrotik::downHotspotCustomer($expiredCustomers[$i]->id);
                    if ($rhspCustomer) {
                        $rhspUserNo++;
                    }
                }
            }
            return response()->json(array(
                'result' => ($staticUserNo != 0 ? $staticUserNo . ' static users ' : '') . ($pppoeUserNo != 0 ? $pppoeUserNo . ' pppoe users ' : '') . ($rhspUserNo != 0 ? $rhspUserNo . ' recurring hotspot users ' : '') . ' downed successfully'
            ));
            return response()->json([
                'success' => true,
                'message' => 'Disconnected expired customers successfully',
                'data' => $expiredCustomers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to disconnect expired customers',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
