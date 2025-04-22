<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EpayPackage extends Model
{
    //
    protected $fillable = [
        'title',
        'password_status',
        'time_limit',
        'data_limit',
        'server',
        'profile',
        'voucher_length',
        'price',
        'mikrotik_id'
    ];
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }
    public function epayVoucher(): HasMany
    {
        return $this->hasMany(HotspotEpay::class);
    }
}
