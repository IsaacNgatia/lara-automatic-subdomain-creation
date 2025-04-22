<?php

namespace App\Models;

use App\Services\MpesaService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentConfig extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_gateway_id',
        'pass_key',
        'client_secret',
        'client_key',
        'client_id',
        'short_code',
        'store_no',
        'till_no',
        'company_name',
        'url_registered',
        'is_working',
        'is_default',
    ];
    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }
    // public function registerMpesaUrl($id){
    //     return MpesaService::registerUrl($id);
    // }
}
