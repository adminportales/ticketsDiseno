<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketDelivery extends Model
{
    protected $fillable = [
        'ticket_id',
        'designer_id',
        'is_accepted'
    ];
}
