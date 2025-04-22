<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'action',
        'ip_address',
        'status',
        'description',
        'user_agent',
        'platform',
        'created_at',
        'updated_at',
    ];
}
