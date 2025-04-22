<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'added_by'
    ];
    /**
     * Get the admin that owns the expense type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\Admin The admin that owns the expense type.
     */
    public function admins(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
