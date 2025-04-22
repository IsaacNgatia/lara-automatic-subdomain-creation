<?php

namespace App\Http\Controllers;

use App\Services\RouterosApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MikrotikController extends Controller
{
    protected $routerosApiService;

    public function __construct(RouterosApiService $routerosApiService)
    {
        $this->routerosApiService = $routerosApiService;
    }

    public function checkStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'ip_address' => 'required|ip',
                'login' => 'required|string',
                'password' => 'required|string',
                'port' => 'integer',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            $connectStatus = $this->routerosApiService->connect($request->get('ip_address'), $request->get('login'), $request->get('password'));
            if (!$connectStatus) {
                return response()->json(array('error' => true, 'message' => 'Error connecting to router', 503));
            }
            $reqData = [
                'ip_address' => $request->get('ip_address'),
                'login' => $request->get('login'),
                'password' => $request->get('password'),
            ];

            $result  = $this->routerosApiService->comm(
                "/queue/simple/add",
                array(
                    "name" => 'test',
                    "target" => '12.23.12.23',
                    "max-limit" => '3M/3M',
                    "limit-at" => '3M/3M',
                    "comment" => "Test 1"
                )
            );
            echo $result;
            die;
        } catch (\Throwable $th) {
            return response()->json(array('error' => $th));
        }
    }
}
