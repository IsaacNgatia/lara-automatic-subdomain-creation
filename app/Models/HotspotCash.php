<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotspotCash extends Model
{
    use HasFactory;

    protected $fillable= [
        'voucher_name',
        'password',
        'reference_number',
        'time_limit',
        'data_limit',
        'server',
        'profile',
        'is_sold',
        'logged_in',
        'mikrotik_id',
        'price',
        'comment',
        'payment_date',
        'expiry_date'
    ];
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }
}
