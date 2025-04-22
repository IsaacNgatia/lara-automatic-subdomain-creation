<?php

namespace App\Models;

use App\Services\SmsService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sms extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_sent',
        'recipient',
        'message',
        'message_id',
        'subject',
        'customer_id',
    ];
    /**
     * Get the customer that received the sent SMS.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @property-read \App\Models\Customer $customer The customer that received the sent SMS.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function sendSupportSMS($to, $message, $subject)
    {
        $smsService = app(SmsService::class); // Resolve the SmsService from the container
        return $smsService->send($to, $message, $subject);
    }
    public static function testSmsConfiguration($to, $message, $subject, $smsConfigId)
    {
        $smsService = app(SmsService::class); // Resolve the SmsService from the container
        return $smsService->testSmsConfiguration($to, $message, $subject, $smsConfigId);
    }
}
