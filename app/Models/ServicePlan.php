<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'max_download',
        'max_upload',
        'mikrotik_id',
        'price',
        'is_active',
        'rate_limit',
        'profile',
        'billing_cycle'
    ];
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }
}
