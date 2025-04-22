<?php

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
