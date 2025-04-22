<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'action',
        'ip_address',
        'entity_type',
        'entity_id',
        'status',
        'description',
        'user_agent',
        'platform',
        'created_at',
        'updated_at',
    ];
    /**
     * Get the admin that owns the admin log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\Admin The admin that owns the admin log.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
