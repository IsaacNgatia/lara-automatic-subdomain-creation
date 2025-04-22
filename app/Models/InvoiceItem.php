<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 'service_plan_id', 'quantity', 'rate', 'sub_total', 'from', 'to',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function servicePlan(){
        return $this->belongsTo(ServicePlan::class);
    }
}
