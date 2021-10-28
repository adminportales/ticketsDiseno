<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    protected $fillable = [
        'ticket_id',
        'reference_id',
        'type'
    ];
    public function ticketInformation()
    {
        return $this->belongsTo('App\TicketInformation','reference_id');
    }
    public function ticketStatusChange()
    {
        return $this->belongsTo('App\TicketStatusChange','reference_id');
    }
    public function ticketMessage()
    {
        return $this->belongsTo('App\Message','reference_id');
    }
    public function ticketDelivery()
    {
        return $this->belongsTo('App\TicketDelivery','reference_id');
    }
}
