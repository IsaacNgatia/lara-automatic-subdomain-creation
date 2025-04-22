<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'customer_id',
        'topic',
        'description',
        'case_number',
        'status',
        'is_replied'
    ];
    /**
     * Get the customer that owns the complaint.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\Customer The customer that owns the complaint.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Get all replies associated with the complaint.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @return \App\Models\ComplaintReply[]|\Illuminate\Database\Eloquent\Collection All replies associated with the complaint.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ComplaintReply::class);
    }
}