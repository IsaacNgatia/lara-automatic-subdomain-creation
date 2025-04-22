<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotspotRecurring extends Model
{
    use HasFactory;
    protected $fillable = [
        'mikrotik_name',
        'password',
        'customer_id',
        'server',
        'profile',
        'disabled',
        'comment',
        'expiry_date',
        'created_at',
        'updated_at',
    ];
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }
}
