<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketInformation extends Model
{
    protected $table = 'ticket_informations';

    protected $fillable = [
        'ticket_id',
        'technique_id',
        'modifier_id',
        'modifier_name',
        'customer',
        'description',
        'title',
        'items',
        'logo',
        'product',
        'pantone',
        'position',
        'companies'
    ];

    public function techniqueTicket()
    {
        return $this->belongsTo('App\Technique', 'technique_id');
    }
}
