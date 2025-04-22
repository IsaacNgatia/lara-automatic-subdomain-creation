<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'expense_type_id',
        'description',
        'amount',
        'is_paid',
        'admin_id'
    ];
    /**
     * Get the expense type that the expense belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\ExpenseType The related expense type.
     */
    public function expenseType(): BelongsTo
    {
        return $this->belongsTo(ExpenseType::class);
    }
    /**
     * Scope a query to only include paid expenses.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Expense[] The collection of paid expenses.
     */
    public function scopeIsPaid(Builder $query): Builder
    {
        return $query->where('is_paid', true);
    }
    /**
     * Scope a query to only include unpaid expenses.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Collection|\App\Models\Expense[] The collection of unpaid expenses.
     */
    public function scopeIsUnpaid(Builder $query): Builder
    {
        return $query->where('is_paid', false);
    }
}
