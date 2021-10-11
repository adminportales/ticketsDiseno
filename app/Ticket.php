<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'seller_id',
        'seller_name',
        'designer_id',
        'designer_name',
        'priority_id',
        'type_id',
    ];

    public function ticketInformation(){

        return $this->hasOne('App\TicketInformation');

    }
}
