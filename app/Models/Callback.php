<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    use HasFactory;
    protected $fillable = [
        'result_description',
        'result_code',
        'merchant_request_id',
        'checkout_request_id',
        'amount',
        'phone',
        'email',
        'name',
        'status',
        'trans_timestamp',
        'trans_id',
        'customer_type',
        'customer_id',
        'payment_gateway_id',
        'updated_at',
    ];
}
