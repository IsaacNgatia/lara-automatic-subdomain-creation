<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_id',
        'type',
        'title',
        'description',
        'user_id'
    ];

    public function responses(){
        return $this->hasMany(TicketResponse::class);
    }
}
