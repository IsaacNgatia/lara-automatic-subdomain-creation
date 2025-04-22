<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountSetting extends Model
{
    protected $fillable = [
        'admin_id',
        'logo',
        'favicon',
        'name',
        'email',
        'url',
        'phone',
        'address',
        'user_url',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
