<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintReply extends Model
{
    use HasFactory;
    protected $fillable = [
        'complaint_id',
        'reply',
        'replied_by'
    ];
    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }
}