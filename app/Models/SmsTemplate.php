<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'template',
        'subject',
        'is_active',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
