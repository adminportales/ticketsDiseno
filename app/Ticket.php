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

    // Toda la informacion del ticket
    public function ticketInformation(){
        return $this->hasMany('App\TicketInformation');
    }

    //Ultima informacion del ticket
    public function latestTicketInformation()
    {
        return $this->hasOne('App\TicketInformation');
    }
    //Traer el tipo de ticket
    public function typeTicket()
    {
        return $this->belongsTo('App\Type', 'type_id');
    }
    //Traer el status de ticket
    public function priorityTicket()
    {
        return $this->belongsTo('App\Priority', 'priority_id');
    }
    //Ultima informacion del ticket
    public function messagesTicket()
    {
        return $this->hasMany('App\Message');
    }
}
