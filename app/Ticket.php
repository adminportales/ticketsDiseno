<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $fillable = [
        'seller_id',
        'creator_name',
        'creator_id',
        'seller_name',
        'designer_id',
        'designer_name',
        'priority_id',
        'type_id',
        'subtype_id',
        'status_id',
    ];

    // Empleado creador del ticket
    public function ticketCreator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    // Toda la informacion del ticket
    public function ticketInformation()
    {
        return $this->hasMany('App\TicketInformation');
    }

    //Ultima informacion del ticket
    public function latestTicketInformation()
    {
        return $this->hasOne('App\TicketInformation')->latestOfMany();
    }

    //Ultima entrega del ticket
    public function latestTicketDelivery()
    {
        return $this->hasOne('App\TicketDelivery')->latestOfMany();
    }

    //Traer el tipo de ticket
    public function typeTicket()
    {
        return $this->belongsTo('App\Type', 'type_id');
    }
    public function subTypeTicket()
    {
        return $this->belongsTo('App\Subtype', 'subtype_id');
    }
    //Traer la prioridad del ticket
    public function priorityTicket()
    {
        return $this->belongsTo('App\Priority', 'priority_id');
    }

    //Funcion para traer los mensajes del los tickets
    public function messagesTicket()
    {
        return $this->hasMany('App\Message');
    }

    //Funcion para traer el historial del ticket
    public function historyTicket()
    {
        return $this->hasMany('App\TicketHistory');
    }

    // Funcion para consulatr las entregas del ticket
    public function deliveryTicket()
    {
        return $this->hasMany('App\TicketDelivery');
    }

    //Traer el status de ticket
    public function statusChangeTicket()
    {
        return $this->hasMany('App\TicketStatusChange');
    }
    //Traer el status de ticket
    public function latestStatusChangeTicket()
    {
        return $this->hasOne('App\TicketStatusChange')->latestOfMany();
    }

    // Traer el diseñador del ticket
    public function designerTicket()
    {
        return $this->belongsTo('App\User', 'designer_id');
    }

    // Traer el proceso de asignacion del ticket
    public function ticketAssignProcess()
    {
        return $this->hasMany('App\TicketAssignProcess');
    }

    // Traer el ultimo proceso de asignacion del ticket
    public function latestTicketAssignProcess()
    {
        return $this->hasOne('App\TicketAssignProcess')->latestOfMany();
    }
}
