<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FailedConnection extends Model
{
    use HasFactory;
    protected $fillable  = [
        'customer_id',
        'attempts',
        'resolved',
        'reason',
        'updated_at'
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
