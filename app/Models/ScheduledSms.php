<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledSms extends Model
{
    protected $fillable = [
        'day_to_send',
        'before_after',
        'template',
        'type',
        'created_by',
    ];
}
