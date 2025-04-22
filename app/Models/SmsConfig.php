<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'sms_provider_id',
        'api_key',
        'sender_id',
        'username',
        'password',
        'short_code',
        'api_secret',
        'is_default',
        'is_working',
        'output_type',
    ];
    public function smsProvider(): BelongsTo
    {
        return $this->belongsTo(SmsProvider::class);
    }
}
