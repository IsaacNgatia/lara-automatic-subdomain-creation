<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'trans_time',
        'trans_amount',
        'short_code',
        'reference_number',
        'org_balance',
        'msisdn',
        'mikrotik_id',
        'customer_type',
        'customer_id',
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'trans_id',
        'trans_type',
        'payment_gateway',
        'is_partial',
        'is_known',
        'valid_from',
        'valid_until',
        'comment',
        'updated_at',
        'created_at',
        'updated_at'
    ];
    /**
     * Scope a query to filter transactions by reference number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type  The reference number to filter by.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByReference(Builder $query, $type): Builder
    {
        return $query->where('reference_number', $type);
    }
    /**
     * Scope a query to filter transactions by transaction ID.
     *
     * This method adds a condition to the query to only include transactions with a specific transaction ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query  The query builder instance.
     * @param  string  $transId  The transaction ID to filter by.
     * @return \Illuminate\Database\Eloquent\Builder  The modified query builder instance.
     */
    public function scopeByTransId(Builder $query, $transId): Builder
    {
        return $query->where('trans_id', $transId);
    }
}
