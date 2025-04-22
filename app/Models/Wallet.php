<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'customer_id',
        'transaction_id',
        'is_excess',
        'is_cleared',
        'created_at',
    ];
    /**
     * This function is a scope for filtering WalletTransaction records by a given reference number.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query The Eloquent query builder instance.
     * @param  string  $reference The reference number to filter by.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder instance with the added filter.
     */
    public function scopeFilterByReferenceNumber($query, $reference)
    {
        return $query->where('reference_number', $reference);
    }
}
