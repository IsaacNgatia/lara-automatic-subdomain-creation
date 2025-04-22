<?php

use App\Services\CountryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('generateRandomNumber')) {
    function generateRandomNumber($length = 6)
    {
        return random_int(10 ** ($length - 1), (10 ** $length) - 1);
    }
}
if (!function_exists('generateRandomSmallAlphaNumeric')) {
    function generateRandomSmallAlphaNumeric($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $password;
    }
}
if (!function_exists('current_currency')) {
    function current_currency()
    {
        return app(CountryService::class)->getCurrentCurrency();
    }
}
if (!function_exists('generateUniqueCashTransactionId')) {
    function generateUniqueCashTransactionId(): string
    {
        do {
            // Generate ID: 'CSH' + 7 random alphanumeric uppercase characters
            $transactionId = 'CSH' . strtoupper(Str::random(7));
        } while (
            DB::table('transactions')->where('trans_id', $transactionId)->exists()
        );

        return $transactionId;
    }
}

if (!function_exists('splitName')) {
    function splitName(string $fullName): array
    {
        $names = explode(' ', trim($fullName));
        $result = [
            'firstName' => null,
            'middleName' => null,
            'lastName' => null,
        ];
        $count = count($names);

        if ($count === 1) {
            $result['firstName'] = $names[0];
        } elseif ($count === 2) {
            $result['firstName'] = $names[0];
            $result['lastName'] = $names[1];
        } elseif ($count === 3) {
            $result['firstName'] = $names[0];
            $result['middleName'] = $names[1];
            $result['lastName'] = $names[2];
        }
        return $result;
    }
}
