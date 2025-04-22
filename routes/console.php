<?php

use App\Services\SmsService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());

    $smsService = new SmsService();

    // Get the current date and time in a readable format
    $dateTime = now()->format('Y-m-d H:i:s');

    // Construct the message with the timestamp
    $message = "Test scheduled task. Happening at {$dateTime}";

    // Try sending the SMS
    $result = $smsService->send(['phone' => '0712345678'], $message, 'Scheduled Task');

    if ($result) {
        Log::info($result);
    } else {
        Log::error('Failed to send SMS in scheduled task.');
    }
})->purpose('Display an inspiring quote')->hourly();
