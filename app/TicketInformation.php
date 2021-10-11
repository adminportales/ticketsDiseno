<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketInformation extends Model
{
    protected $table = 'ticket_informations';

    protected $fillable = [
        'ticket_id',
        'status_id',
        'customer',
        'technique',
        'description',
        'title',
        'logo',
        'product',
        'pantone',
    ];

    //Traer el status de ticket
    public function statusTicket()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }
}
