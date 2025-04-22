<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'level',
        'event_type',
        'message',
        'status',
        'description',
        'file_path',
        'source',
        'created_at',
        'updated_at',
    ];
}
